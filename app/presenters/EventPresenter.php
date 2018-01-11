<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 1. 8. 2016
 * Time: 13:07
 */

namespace App\Presenters;


use App\Forms\AddEventFormFactory;
use App\Forms\AddThreadFormFactory;
use App\Forms\SignForEventFormFactory;
use App\Model;
use App\Model\PermissionRepository as Permission;
use Nette\Application\BadRequestException;
use Nette\Application\ForbiddenRequestException;
use Nette\Application\UI\Form;

use  \blitzik\Calendar\Calendar as Calendar;

use App\Components\Calendar\CalendarFactory as CalendarCellFactory;
use App\Components\Calendar\CalendarGenerator;
use Nette\Security\User;
use Nette\Utils\DateTime;


class EventPresenter extends BaseSecurePresenter
{

    /** @var Model\EventFacade
     * @inject
     */
    public $eventFacade;

    /** @var Model\ThreadFacade
     * @inject
     */
    public $threadFacade;

    /** @var \Nette\Database\Context @inject */
    public $database;

    /** @var \Texy\Texy @inject */
    public $texy;


    public function renderDefault($all = false)
    {
        if ($all) {
            $events = $this->eventFacade->findAll();

            $userSigns = $this->eventFacade->findSignsByUser($this->user->id);

        } else {
            //only future events
            $events = $this->eventFacade->findFuture();
            $userSigns = $this->eventFacade->findSignsByUserForFutureEvents($this->user->id);
        }



        $signedFor = [];
        foreach ($userSigns as $sign) {
            $signedFor[$sign->event_id] = $sign->type;
        }

        $eventSigns = [];
        foreach ($events as $event) {
            $eventSigns[$event->id] = $this->eventFacade->getSigned($event->id);
        }

        $this->template->events = $events;
        $this->template->signedFor = $signedFor;
        $this->template->eventSigns = $eventSigns;
        $this->template->showLinkType = !$all;

    }

    public function renderCalendar()
    {
    }

    public function actionShow($id)
    {
        $roles = $this->eventFacade->fetchRolesByEvent($id);

        $this->template->event = $event = $this->eventFacade->get($id);
        $this->template->userCanEdit = $this->userCanEdit($event->user_id);
        $this->template->roles = $roles;
        $this->template->signs = $this->eventFacade->getSigned($id);
        $this->template->threads = $threads = $this->threadFacade->findByEventId($this->user->id, $id);
        $this->template->unreadCounts = $this->threadFacade->getUnreadPostsCountsBySelection($this->user->id,$threads);
        $this->template->previous = $this->eventFacade->getPrevious($id,$event['date_from']);
        $this->template->next = $this->eventFacade->getNext($id,$event['date_from']);


        $roles = array_merge([null => ''], $roles);
        $this['signForEventForm']['role']->setItems($roles);
        $this['signForEventForm']['event_id']->setValue($id);
        $dateFromTxt = (new DateTime($event->date_from))->format('d.m.Y H:i');
        $dateToTxt = (new DateTime($event->date_to))->format('d.m.Y H:i');
        $dateMinTxt = (new DateTime($event->date_from))->sub(new \DateInterval('P1D'))->format('d.m.Y H:i');
        $dateMaxTxt = (new DateTime($event->date_to))->add(new \DateInterval('P1D'))->format('d.m.Y H:i');
        $hourFrom =  (new DateTime($event->date_from))->format('H');
        $minuteFrom =  (new DateTime($event->date_from))->format('i');
        $hourTo =  (new DateTime($event->date_to))->format('H');
        $minuteTo =  (new DateTime($event->date_to))->format('i');

        $this['signForEventForm']['date_from']
            ->setAttribute('data-min-date',$dateMinTxt)
            ->setAttribute('data-max-date',$dateMaxTxt)
            ->setAttribute('data-default-date',$dateFromTxt)
            ->setAttribute('data-default-hour',$hourFrom)
            ->setAttribute('data-default-minute',$minuteFrom);

        $this['signForEventForm']['date_to']
            ->setAttribute('data-min-date',$dateMinTxt)
            ->setAttribute('data-max-date',$dateMaxTxt)
            ->setAttribute('data-default-date',$dateToTxt)
            ->setAttribute('data-default-hour',$hourTo)
            ->setAttribute('data-default-minute',$minuteTo);
        $this['addThreadForm']->setDefaults(['event_id' => $id]);

        $userSign = $this->eventFacade->getSign($id, $this->user->id);
        if ($userSign && $userSign->role) {
            $this['signForEventForm']->setDefaults(['role' => $userSign->role->slug]);
        }

    }

    public function actionEdit($id)
    {
        $event = $this->eventFacade->get($id);

        if (!$event) {
            throw new BadRequestException();
        }

        if (!$this->userCanEdit($event->user_id)) {
            throw new ForbiddenRequestException();
        }


        $this->template->event = $event;

        $eventRoles = $this->eventFacade->fetchRolesByEventSerialized($id);

        $this['addEventForm']->setDefaults([
            'event_id'    => $id,
            'title'       => $event->title,
            'description' => $event->description,
            'date_from'   => $event->date_from,
            'date_to'     => $event->date_to,
            'location'    => $event->location,
            'roles'       => $eventRoles]);

        $this['addEventForm']['send']->caption = 'Uložit úpravy';
    }

    public function actionExportCalendar() {
        $user = $this->profileRepository->get($this->user->id);
        
        $token = $user['calendar_token'];
        if (!$token) {
            $token = (new Model\UserManager($this->database,$this->profileRepository))
                ->getCalendarExportToken($this->user->id);
        }
        
        $this->template->calendarLink = $this->link('Api:calendar',[$this->user->id,$token]);
        $this->template->calendarAllLink = $this->link('Api:calendar',[$this->user->id,$token,true]);
        $this->template->calendarAllNotRejectedLink = $this->link('Api:calendar',[$this->user->id,$token,true,false]);
    }   


    protected function createComponentCalendar()
    {
        $cal = new Calendar(Calendar::LANG_CS);


        $factory = new CalendarCellFactory(Calendar::MONDAY);
        $gen = new CalendarGenerator($factory, $this->eventFacade);

        $cal->setCalendarGenerator($gen);
        $cal->enableSelections();
        $cal->setCalendarBlocksTemplate(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
            'templates' . DIRECTORY_SEPARATOR . 'calendarBlocks.latte');

        return $cal;
    }


    public function createComponentAddEventForm()
    {
        $form = (new AddEventFormFactory())->create();
        $form->onSuccess[] = array($this, 'addEventFormSucceeded');

        return $form;
    }

    public function addEventFormSucceeded($form, $values)
    {
        $this->onlyWithPermission(Permission::ADD_EVENT);

        $values['description'] = $this->texy->process($values['description']);

        $eventId = $values['event_id'];
        if (!$eventId) {
            $eventId = $this->eventFacade->addEvent($this->user->id, $values['title'],
                $values['date_from'], $values['date_to'], $values['location'], $values['description']);
        } else {
            $event = $this->eventFacade->get($eventId);

            if (!$this->userCanEdit($event->user_id)) {
                throw new ForbiddenRequestException();
            }

            $event->update([
                'title'       => $values['title'],
                'description' => $values['description'],
                'location'    => $values['location'],
                'date_from'   => $values['date_from'],
                'date_to'     => $values['date_to'],
            ]);
            $this->eventFacade->removeRolesFromEvent($eventId);
        }

        $this->eventFacade->addRolesSerialized($values['roles'], $eventId);
        if ($eventId) $this->eventFacade->deleteSignsWithNoEventRelation();
        

        $this->redirect('Event:show', $eventId);
    }

    public function createComponentSignForEventForm()
    {
        $form = (new SignForEventFormFactory())->create();
        $form->onSuccess[] = array($this, 'signForEventFormSucceeded');
        return $form;
    }

    public function signForEventFormSucceeded($form, $values)
    {
        if ($form->isSubmitted()->name == 'sendMaybe') {
            $type = \App\Model\SignEnum::MAYBE;
            $this->flashMessage('Snad tě uvidíme na akci!', 'success');
        } else {
            $type = \App\Model\SignEnum::YES;
            $this->flashMessage('Jsme rádi, že jedeš. Bude prča!', 'success');
        }
        $this->eventFacade->addSign($values['event_id'], $this->user->id, $type,
            $values['role'], $values['date_from'], $values['date_to'], $values['note']);

        $this->redirect('Event:show', $values['event_id']);


    }

    public function createComponentAddThreadForm()
    {
        $form = (new AddThreadFormFactory())->create();

        $form->onSuccess[] = array($this, 'addThreadFormSucceeded');

        return $form;
    }

    public function addThreadFormSucceeded($form, $values)
    {
        $this->threadFacade->addThread($this->user->id, $values['title'], $values['restrict_users'], $values['event_id']);
    }

    public function handleSign($eventId, $signType)
    {
        if (!($signType == Model\SignEnum::NO)) { //ONLY REFUSING
            throw new BadRequestException;
        }
        $this->eventFacade->addSign($eventId, $this->user->id, $signType);
        $this->flashMessage('Super, píšu si.');
        $this->redirect('Event:show', $eventId);
    }

    public function handleDeleteEvent($eventId)
    {
        $event = $this->eventFacade->get($eventId);

        if (!$this->userCanEdit($event->user_id)) {
            throw new ForbiddenRequestException();
        }

        $this->eventFacade->delete($eventId);

        $this->flashMessage('Smazáno.', 'success');

        $this->redirect('Event:default');
    }

    private function userCanEdit($eventAuthorId)
    {
        return ($this->user->isInRole(Permission::MANAGE_EVENTS) || $this->user->id == $eventAuthorId);
    }


    public function handleRemoveSign($eventId, $userId)
    {
        if (!$this->user->id == $userId) {
            throw new ForbiddenRequestException();
        }

        $this->eventFacade->deleteSign($eventId, $userId);

        $this->flashMessage('Tvoje přihláška je fuč.', 'success');
        $this->redirect('this');
    }
}