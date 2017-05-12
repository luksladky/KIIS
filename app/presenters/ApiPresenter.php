<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 11. 12. 2016
 * Time: 18:21
 */

namespace App\Presenters;

use App\Model;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\Responses\TextResponse;
use Nette\Database\Context as Database;
use Nette\NotImplementedException;
use Nette\Security\AuthenticationException;
use Nette\Security\Permission;
use Nette\Utils\DateTime;
use Nette\Utils\Strings;

class ApiPresenter extends BasePresenter
{


    /** @var Model\EventFacade
     * @inject
     */
    public $eventFacade;

    /** @var Model\ProfileRepository
     * @inject
     */
    public $profileRepository;

    /** @var Model\ThreadFacade
     * @inject
     */
    public $threadFacade;


    /** @var Model\PermissionRepository 
     * @inject 
     */
    public $permissionRepository;


    /** @var Model\CronManager
     * @inject
     */
    public $cronManager;

    public function actionGetRoles()
    {
        $this->onlyLoggedUser();
        $roles = $this->eventFacade->fetchRoles();

        $roleJson = [];
        foreach ($roles as $role) {
            $roleJson[] = array("name" => $role);
        }

        $this->sendResponse(new JsonResponse($roleJson));
    }

    public function actionGetUsers()
    {
        $this->onlyLoggedUser();
        $users = $this->profileRepository->findAll();

        $userJson = [];
        foreach ($users as $user) {
            $userJson[] = array("nickname" => $user->nickname, "id" => $user->id, "name" => $user->name);
        }

        $this->sendResponse(new JsonResponse($userJson));
    }

    public function actionGetPostLikes($postId)
    {
        $likes = $this->threadFacade->getPostLikes($postId);
        $s = '';
        $iterator = 0;
        foreach ($likes as $like) {
            $iterator++;
            $s = $s . ($like->user->nickname);
            if ($iterator != $likes->count())
                $s = $s . ', ';
        }

        if ($s == '') {
            $s = 'Nikdo...';
        }

        $this->sendResponse(new TextResponse($s));
    }

    public function actionLoginAs($userId) {
        if (!$this->user->isInRole(\App\Model\PermissionRepository::MODIFY_USER))
            throw new \Nette\Security\AuthenticationException();
        $row = $this->profileRepository->findBy('id', $userId)->fetch();

        $arr = $row->toArray();
        $arr['confirmed'] = is_null($arr['registration_token']);
        unset($arr['hash']);
        unset($arr['reset_token']);
        unset($arr['registration_token']);
        
        $roles = $this->permissionRepository->findBy('user_id', $userId)->fetchPairs(null, 'permission_slug');
        $identity =  new \Nette\Security\Identity($userId, $roles, $arr);
        $identity->previousIdentity = $this->user->getIdentity();
        
        $this->user->login($identity);
        $this->redirect('Homepage:default');
    }
    
    public function renderRefreshMenu(){

        $profile = $this->profileRepository->get($this->user->id);

        if ($profile['logout']) {
            $this->user->logout(true);
            $profile->update(['logout' => false]);
        }

        if (!$this->user->isInRole(Model\PermissionRepository::MEMBER)) {
            throw new AuthenticationException();
        }



        $this->template->unreadThreadsCount = $c1 = $this->threadFacade->getUnreadThreadsCount($this->user->id);
        $this->template->unreadEventThreadsCount = $c2 = $this->threadFacade->getUnreadThreadsCount($this->user->id, true);
        $this->template->readLaterThreadsCount = $this->threadFacade->getReadLaterThreadsCount($this->user->id);
        $this->template->readLaterEventThreadsCount = $this->threadFacade->getReadLaterThreadsCount($this->user->id, true);

        $this->template->newEventsCount = $c3 = $this->eventFacade->getNewEventsCount($this->user->id);
        $c4 = 0;
        if ($this->user->isInRole(Model\PermissionRepository::MODIFY_USER))
            $this->template->awaitingApprovalCount = $c4 = $this->profileRepository->findAwaitingApproval()->count();


//        $refreshMenu = $c1 > 0 || $c2 > 0 || $c3 > 0 || $c4 > 0;
        
        $this->redrawControl('badgeEventThreads');
        $this->redrawControl('badgeDashboard');
        $this->redrawControl('badgeMobileAll');
    }
    
    public function actionCheckCron() {
        $this->cronManager->check();
        $this->sendResponse(new TextResponse('cron performed'));
    }


    public function actionCalendar($userId, $key, $all = false, $includeRejected = true)
    {
        if ($userId) {
            $userToken = $this->profileRepository->get($userId)->calendar_token;

            if (!$key || $userToken != $key) {
                throw new AuthenticationException('Calendar token is not correct.');
            }

            if ($all) {
                if ($includeRejected) {
                    $events = $this->eventFacade->findAll();
                } else {
                    $events = $this->eventFacade->findNotRejected($userId);
                }
            } else {
                $events = $this->eventFacade->findSignedNotRejected($userId);
            }
        } else {
            throw new AuthenticationException('User id not provided.');
        }

        // 1. Create new calendar
        $vCalendar = new \Eluceo\iCal\Component\Calendar('Klub Hrádek - přihlášen na akce');
        $vCalendar->setName('Klub Hrádek - Akce z KIISu');
        foreach ($events as $event) {
            $vEvent = new \Eluceo\iCal\Component\Event();

            $vEvent->setDtStart($event->date_from);
            $vEvent->setDtEnd($event->date_to);
            $vEvent->setNoTime(false);

            $vEvent->setSummary($event->title);
            $vEvent->setDescription(strip_tags($event->description) . PHP_EOL . $this->template->baseUrl . $this->link('Event:show', $event->id));
            $vEvent->setLocation($event->location);
            $vEvent->setUniqueId($event->id);
            $vEvent->setModified(new DateTime());
//            $vEvent->setUrl($this->template->baseUrl.$this->link('Event:show', $event->id));
            $vCalendar->addComponent($vEvent);
        }

        $response = (new TextResponse($vCalendar->render()));
        $this->getHttpResponse()->setHeader('Content-Type', 'text/calendar');
        $this->getHttpResponse()->setHeader('Content-Disposition', 'Attachment;filename=cal.ics');
        $this->sendResponse($response);
//
//        header('Content-Type: text/calendar; charset=utf-8');
//        echo $vCalendar->render();
//        exit();

    }


//    public function actionRestoreEventRoles()
//    {
//        $this->onlyLoggedUser();
//        $roles = $this->threadFacade->database->query('SELECT id, FUNKCE as funkce from AKCE');
//
//        foreach ($roles as $role) {
//            $funkce = preg_split("/[;,]/", $role->funkce);
//            foreach ($funkce as $f)
//                $this->eventFacade->addRole($f, $role->id);
//        }
//
//        $this->sendResponse(new TextResponse('message'));
//    }
//
//    public function actionRestoreEventSigns()
//    {
//
//        $this->onlyLoggedUser();
//        $events = $this->threadFacade->database->query('SELECT id as event_id, PRIHLASENI as funkce FROM AKCE');
//
//        $signs = [];
//        foreach ($events as $event) {
//            $funkce = preg_split("/[;,]/", $event->funkce);
//            foreach ($funkce as $f) {
//                if ($f == '') continue;
//                $double = preg_split("/[:]/", $f);
//                $roleName = $double[0];
//                if (count($double) > 1) {
//                    $nick = $double[1];
//                    $profile = $this->profileRepository->findBy('nickname', $nick);
//                    if (!$profile->count() == 1) continue;
//
//                    $profile = $profile->fetch();
//
//                    $this->eventFacade->addSign($event->event_id, $profile->id, \App\Model\SignEnum::YES, Strings::webalize($roleName));
//
//
//                }
//            }
//        }
//
//        $this->sendResponse(new TextResponse('message'));
//    }
//
//    public function actionRestoreEventData()
//    {
//        $this->onlyLoggedUser();
//        $roles = $this->threadFacade->database->query('SELECT id, FUNKCE as funkce from AKCE');
//
//        foreach ($roles as $role) {
//            $funkce = preg_split("/[;,]/", $role->funkce);
//            foreach ($funkce as $f)
//                $this->eventFacade->addRole($f, $role->id);
//        }
//
//
//        $events = $this->threadFacade->database->query('SELECT id as event_id, PRIHLASENI as funkce FROM AKCE');
//
//        $signs = [];
//        foreach ($events as $event) {
//            $funkce = preg_split("/[;,]/", $event->funkce);
//            foreach ($funkce as $f) {
//                if ($f == '') continue;
//                $double = preg_split("/[:]/", $f);
//                $roleName = $double[0];
//                if (count($double) > 1) {
//                    $nick = $double[1];
//                    $profile = $this->profileRepository->findBy('nickname', $nick);
//                    if (!$profile->count() == 1) continue;
//
//                    $profile = $profile->fetch();
//
//                    $this->eventFacade->addSign($event->event_id, $profile->id, \App\Model\SignEnum::YES, Strings::webalize($roleName));
//
//
//                }
//            }
//        }
//        $this->flashMessage('Povedlo se');
//        $this->redirect('Event:default');
//        $this->sendResponse(new TextResponse('hotovo'));
//    }

    public function onlyLoggedUser()
    {
        if (!$this->user->isInRole('member')) {
            throw new AuthenticationException('You don\'t have permission to view this.');
        }
    }

}