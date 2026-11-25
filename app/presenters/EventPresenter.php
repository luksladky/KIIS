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
use App\Model\EventFacade;
use App\Model\EventRepository;
use Nette\Security\User;
use Nette\Utils\DateTime;
use Nette;
use Texy\Module;

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

    public function renderListPublic($all = false, $year = null) {
        $this->template->setFile(__DIR__ . "/../templates/Event/default.latte");
        $this->renderDefault(Model\EventRepository::EVENT_PUBLIC, $all, $year);
    }

    public function renderListEducation($all = false, $year = null) {
        $this->template->setFile(__DIR__ . "/../templates/Event/default.latte");
        $this->renderDefault(Model\EventRepository::EVENT_EDUCATION, $all, $year);
    }

    public function renderList($eventType, $all = false) {
        switch ($eventType) {
            case EventRepository::EVENT_PUBLIC:
                $this->forward("Event:listPublic", $all);
                break;
            case EventRepository::EVENT_EDUCATION:
                $this->forward("Event:listEducation", $all);
                break;
        }
    }

    public function renderDefault($type = Model\EventRepository::EVENT_PUBLIC, $all = false, $year = null)
    {
        // year => number of events, oldest first (year navigation; compact links at the bottom of the upcoming view)
        $yearCounts = [];
        foreach ($this->database->query(
            'SELECT YEAR(date_from) AS y, COUNT(*) AS n FROM event WHERE event_type = ? GROUP BY y ORDER BY y ASC', $type
        ) as $row) {
            $yearCounts[(int) $row->y] = (int) $row->n;
        }
        $prevYear = $nextYear = null;
        if ($all) {
            // the list of all events is paginated by year
            $years = array_keys($yearCounts);
            $year = (int) $year;
            if (!isset($yearCounts[$year])) {
                $year = isset($yearCounts[(int) date('Y')]) ? (int) date('Y') : (int) end($years);
            }
            $pos = array_search($year, $years, true);
            if ($pos !== false) {
                $prevYear = $pos > 0 ? $years[$pos - 1] : null;
                $nextYear = $pos < count($years) - 1 ? $years[$pos + 1] : null;
            }
            $events = $this->eventFacade->findAll()->where('event_type = ?', $type)
                ->where('date_from >= ? AND date_from < ?', $year . '-01-01', ($year + 1) . '-01-01');

            $userSigns = $this->eventFacade->findSignsByUser($this->user->id);

        } else {
            //only future events
            $events = $this->eventFacade->findFuture()->where('event_type = ?', $type);
            $userSigns = $this->eventFacade->findSignsByUserForFutureEvents($this->user->id);
        }

        $roleSlugs = $this->database->table('role')->fetchPairs('id', 'slug');
        $signedFor = [];
        $mySigns = []; // eventId => ['type' => ..., 'role' => slug|null], for the quick sign-up in the list
        foreach ($userSigns as $sign) {
            $signedFor[$sign->event_id] = $sign->type;
            $mySigns[$sign->event_id] = [
                'type' => $sign->type,
                'role' => $sign->role_id && isset($roleSlugs[$sign->role_id]) ? $roleSlugs[$sign->role_id] : null,
            ];
        }

        $now = new DateTime();
        $eventSigns = [];
        $eventRoles = []; // only upcoming events can be signed up for from the list
        foreach ($events as $event) {
            $eventSigns[$event->id] = $this->eventFacade->getSigned($event->id);
            unset($eventSigns[$event->id][\App\Model\SignEnum::NO]);
            if ($event->date_to > $now) {
                $eventRoles[$event->id] = $this->eventFacade->fetchRolesByEvent($event->id);
            }
        }
        $this->template->mySigns = $mySigns;
        $this->template->eventRoles = $eventRoles;

        $this->template->events = $events;
        $this->template->eventType = $type;
        $this->template->signedFor = $signedFor;
        $this->template->eventSigns = $eventSigns;
        $this->template->showLinkType = !$all;
        $this->template->yearCounts = $yearCounts;
        $this->template->isYearView = (bool) $all;
        $this->template->currentYear = (int) date('Y');
        $this->template->year = $year;
        $this->template->prevYear = $prevYear;
        $this->template->nextYear = $nextYear;
        $this->template->monthNames = [1 => 'Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen',
            'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'];

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
        $this->template->files = $this->fileRepository->findFor($id, 'event');


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

    public function actionCreate($type) {
        $this['addEventForm']->setDefaults([
            'event_type'    => $type]);
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
        $this->template->calendarFutureLink = $this->link('Api:calendar',[$this->user->id,$token,true,true,true]);
        $this->template->calendarFutureNotRejectedLink = $this->link('Api:calendar',[$this->user->id,$token,true,false,true]);
    }   


    protected function createComponentCalendar()
    {
        $cal = new Calendar(Calendar::LANG_CS);


        $factory = new CalendarCellFactory(Calendar::MONDAY);
        $gen = new CalendarGenerator($factory, $this->eventFacade, $this->user->id);

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
            $eventId = $this->eventFacade->addEvent($this->user->id, $values['event_type'], $values['title'],
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

        /** @var Nette\Http\FileUpload[] $upload */
        $upload = $values['upload'];
        foreach ($upload as $file) {
            $this->fileRepository->insertFile($file, $eventId, 'event', $this->user->getId());
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

    /** Sign up (yes / maybe / no, with a role) straight from the event list. */
    public function handleQuickSign()
    {
        $post = $this->getRequest()->getPost();
        $eventId = isset($post['event_id']) ? (int) $post['event_id'] : 0;
        $type = isset($post['type']) ? $post['type'] : null;
        $event = $eventId ? $this->eventFacade->get($eventId) : null;
        $types = [Model\SignEnum::YES, Model\SignEnum::MAYBE, Model\SignEnum::NO];

        if (!$event || !in_array($type, $types, true)) {
            throw new BadRequestException;
        }
        $back = $this->link('this') . '#event-' . $eventId;

        if ($event->date_to < new DateTime()) {
            $this->flashMessage('Tahle akce už proběhla.', 'warning');
            $this->redirectUrl($back);
        }

        $role = null;
        if ($type !== Model\SignEnum::NO) {
            $roles = $this->eventFacade->fetchRolesByEvent($eventId);
            $role = isset($post['role']) ? $post['role'] : null;
            if ($roles && !isset($roles[$role])) {
                $this->flashMessage('Co budeš dělat na akci? Vyber si funkci.', 'warning');
                $this->redirectUrl($back);
            }
        }

        // keep arrival, departure and note that were set on the detail page
        $existing = $this->database->table('user_event')
            ->where('event_id = ? AND user_id = ?', $eventId, $this->user->id)->fetch();
        $this->eventFacade->addSign($eventId, $this->user->id, $type, $role,
            $existing ? $existing->date_from : null,
            $existing ? $existing->date_to : null,
            $existing ? $existing->note : null);

        $messages = [
            Model\SignEnum::YES   => ['Jsme rádi, že jedeš. Bude prča!', 'success'],
            Model\SignEnum::MAYBE => ['Snad tě uvidíme na akci!', 'success'],
            Model\SignEnum::NO    => ['Škoda, tak příště!', 'info'],
        ];
        $this->flashMessage($messages[$type][0], $messages[$type][1]);
        $this->redirectUrl($back);
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