<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 8. 8. 2016
 * Time: 22:24
 */

namespace App\Model;

use Nette,
    Nette\Database\Context as Database;
use Nette\Utils\Strings;

abstract class SignEnum
{
    const YES = "yes";
    const MAYBE = "maybe";
    const NO = "no";
}

class EventFacade
{

    /** @var Database */
    public $database;

    private $eventRepository;
    private $rolesRepository;
    private $eventSignRepository;
    private $threadRepository;
    private $profileRepository;

    /**
     * EventFacade constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    private function getEventRepository()
    {
        if (!$this->eventRepository) {
            $this->eventRepository = new EventRepository($this->database);
        }
        return $this->eventRepository;
    }

    private function getRolesRepository()
    {
        if (!$this->rolesRepository) {
            $this->rolesRepository = new RolesRepository($this->database);
        }
        return $this->rolesRepository;
    }

    private function getEventSignRepository()
    {
        if (!$this->eventSignRepository) {
            $this->eventSignRepository = new EventSignRepository($this->database);
        }
        return $this->eventSignRepository;
    }

    private function getThreadRepository()
    {
        if (!$this->threadRepository) {
            $this->threadRepository = new ThreadRepository($this->database);
        }
        return $this->threadRepository;
    }

    private function getProfileRepository()
    {
        if (!$this->profileRepository) {
            $this->profileRepository = new ProfileRepository($this->database);
        }
        return $this->profileRepository;
    }

    /**********************
     * /**** EVENT ***********
     ***********************/


    public function get($eventId)
    {
        return $this->getEventRepository()->get($eventId);
    }

    public function addEvent($userId, $eventType, $title, $date_from, $date_to, $location, $description = null)
    {

        $data = array('user_id'     => $userId,
                      'event_type'  => $eventType,
                      'title'       => $title,
                      'date_from'   => $date_from,
                      'date_to'     => $date_to,
                      'location'    => $location,
                      'description' => $description);

        return $this->getEventRepository()->insert($data)->getPrimary();
    }

    public function findNotRejected($userId, $orderBy = EventRepository::BY_DATE_FROM, $desc = false, $limit = null, $offset = null)
    {
        $rejectedIds = $this->getEventSignRepository()->findBy('user_id = ? AND type = ?', [$userId, SignEnum::NO])->fetchPairs(null, 'event_id');
        $rejectedIds[] = -1;

        $orderFunc = EventRepository::getOrderFunction($orderBy, $desc);
        $events = $orderFunc($this->getEventRepository()->findBy('id NOT IN ?', $rejectedIds))->limit($limit, $offset);

        return $events;
    }

    public function findAll($orderBy = EventRepository::BY_DATE_FROM, $desc = false, $limit = null, $offset = null)
    {
        $orderFunc = EventRepository::getOrderFunction($orderBy, $desc);
        return $orderFunc($this->getEventRepository()->findAll()->limit($limit, $offset));
    }

    public function findFuture($orderBy = EventRepository::BY_DATE_FROM, $desc = false, $limit = null, $offset = null)
    {
        $orderFunc = EventRepository::getOrderFunction($orderBy, $desc);
        return $orderFunc($this->getEventRepository()->findBy('date_to > ?', new Nette\Utils\DateTime())->limit($limit, $offset));
    }

    public function findFutureNotRejected($userId, $orderBy = EventRepository::BY_DATE_FROM, $desc = false, $limit = null, $offset = null)
    {
        $eventIds = $this->getEventSignRepository()->findBy('(user_id = ?) AND (type = ?)', [$userId, SignEnum::NO])->fetchPairs(null, 'event_id');
        $eventIds[] = -1;

        $orderFunc = EventRepository::getOrderFunction($orderBy, $desc);
        $events = $orderFunc($this->getEventRepository()->findBy('(id NOT IN ?) AND (date_to > ?)', [$eventIds, new Nette\Utils\DateTime()]))->limit($limit, $offset);

        return $events;
    }

    public function findNearest($maxDaysLeft = 14)
    {
        $dateFrom = (new Nette\Utils\DateTime());
        $dateTo = (new Nette\Utils\DateTime())->add(new \DateInterval('P' . $maxDaysLeft . 'D'));

        return $this->findInInterval($dateFrom, $dateTo);
    }

    public function findInInterval($dateFrom, $dateTo)
    {
        return $this->getEventRepository()->findBy('(date_from > ?) AND (date_from < ?)', [$dateFrom, $dateTo]);
    }


    public function findNearestMaybe()
    {
        $users = $this->getProfileRepository()->findAll();

        $userWithEvents = [];

        $nearestEventsId = $this->findNearest()->fetchPairs(null, 'id');
        foreach ($users as $user) {

            $signIds = $this->getEventSignRepository()
                ->findBy("(user_id = ?) AND (event_id IN ?) AND (type IN ?)", [$user->id, $nearestEventsId, ['yes', 'no']])
                ->fetchPairs(null, 'event_id');
            $signIds[] = -1;

                $events = $this->findNearest()->where('id NOT IN ?', $signIds);
            if ($events->count() > 0) {
                $userWithEvents[] = ['user' => $user, 'events' => $events];
            }
        }

        return $userWithEvents;
    }


    public function findForDay($year, $month, $day)
    {
        $dateFrom = (new Nette\Utils\DateTime())->setDate($year, $month, $day)->setTime(23, 59, 59);
        $dateTo = (new Nette\Utils\DateTime())->setDate($year, $month, $day)->setTime(0, 0, 0);

        return $this->getEventRepository()->findBy('date_from < ? AND date_to > ?', [$dateFrom, $dateTo]);
    }

    public function findSigned($userId)
    {
        $eventIds = $this->getEventSignRepository()->findBy('user_id', $userId)->fetchPairs(null, 'event_id');

        $events = $this->getEventRepository()->findBy('id IN', $eventIds);

        return $events;
    }

    public function findSignedNotRejected($userId)
    {
        $rejectedIds = $this->getEventSignRepository()->findBy('user_id = ? AND type = ?', [$userId, SignEnum::NO])->fetchPairs(null, 'event_id');
        $rejectedIds[] = -1;


        return $this->findSigned($userId)->where('id NOT IN ?', $rejectedIds);
    }

    public function getNext($eventId, $dateFrom)
    {
        return $this->getEventRepository()->findBy('id <> ? AND date_from > ?', [$eventId, $dateFrom])
            ->order('date_from ASC')->limit(1)->fetch();
    }

    public function getPrevious($eventId, $dateFrom)
    {
        return $this->getEventRepository()->findBy('id <> ? AND date_from < ?', [$eventId, $dateFrom])
            ->order('date_from DESC')->limit(1)->fetch();
    }

    public function delete($eventId)
    {
        $this->getEventRepository()->get($eventId)->delete();

        $this->getThreadRepository()->findBy('event_id', $eventId)->delete();
    }

    public function getNewEventsCount($userId, $eventType)
    {
        $user = $this->getProfileRepository()->get($userId);
        return $this->getEventRepository()
                    ->findBy('created_at > ?', $user->last_activity)
                    ->where('event_type = ?', $eventType)
                    ->count();
    }

    /**********************
     * /**** ROLES ***********
     ***********************/

    public function addRole($name, $eventId)
    {
        $slug = Strings::webalize($name);

        if ($slug == "") return false;

        $role = $this->getRolesRepository()->findBy('slug', $slug);
        
        if ($role->count() == 0) {
            $roleId = $this->getRolesRepository()->insert(array(
                'title' => $name,
                'slug'  => $slug,
            ));
        } else {
            $roleId = $role->fetch()->id;
        }

        $this->database->table('event_role')->insert(array(
            'role_id'  => $roleId,
            'event_id' => $eventId,
        ));

        return $roleId;
    }

    public function addRolesSerialized($serializedRoles, $eventId)
    {
        $roles = preg_split("/[;,]/", $serializedRoles);

        foreach ($roles as $role) {
            try {
                $this->addRole($role, $eventId);
            } catch (Exception $exception) {

            }

        }
    }

    public function fetchRolesByEvent($eventId)
    {
        $ids = $this->database->query('SELECT role_id FROM event_role WHERE event_id = ?', $eventId)->fetchPairs(null, 'role_id');


        return $this->getRolesRepository()->findBy('id IN', $ids)->fetchPairs('slug', 'title');
    }

    public function fetchRolesByEventSerialized($eventId)
    {
        $roles = $this->fetchRolesByEvent($eventId);
        $roleNames = [];
        foreach ($roles as $role) {
            $roleNames[] = $role;
        }

        return implode(',', $roleNames);
    }

    public function fetchRoles()
    {
        return $this->getRolesRepository()->findAll()->fetchPairs(null, 'title');
    }

    public function removeRolesFromEvent($eventId)
    {
        return $this->database->table('event_role')->where('event_id', $eventId)->delete();
    }

    /**********************
     * /**** SIGNS FOR EVENT ***********
     ***********************/


    public function addSign($eventId, $userId, $signType, $roleSlug = null, $dateFrom = null, $dateTo = null, $note = null)
    {
        $sign = $this->getEventSignRepository()->findBy('event_id = ? AND user_id = ?', array($eventId, $userId));
        if ($role = $this->getRolesRepository()->findBy('slug', $roleSlug)->fetch()) {
            $roleId = $role->id;
        } else {
            $roleId = null;
        }
        $data = array('event_id'  => $eventId,
                      'user_id'   => $userId,
                      'type'      => $signType,
                      'role_id'   => $roleId,
                      'date_from' => $dateFrom,
                      'date_to'   => $dateTo,
                      'note'      => $note);

        if (!$sign->fetch()) {
            $this->getEventSignRepository()->insert($data);
        } else {
            $sign->update($data);
        }
    }

    public function getSigned($eventId)
    {
        $signs = $this->getEventSignRepository()->findBy('event_id', $eventId);
        $roles = $this->fetchRolesByEvent($eventId);

        $result = array();
        foreach ($roles as $slug => $name) {
            $result[$slug] = array('name'    => $name,
                                   'main'    => true,
                                   'persons' => array());
        }

//        $result[ParticipationEnum::MAYBE] = array('name' => 'Možná přijde', 'main'=>false,'persons' => array());
        $result[SignEnum::NO] = array('name' => 'Nemůže', 'main' => false, 'persons' => array());


        foreach ($signs as $sign) {
            if (isset($sign->role_id))
                $result[$sign->role->slug]['persons'][] = $sign;
            else {
                $result[$sign->type]['persons'][] = $sign;
            }
        }

        return $result;
    }

    public function findSignsByEvent($eventId)
    {
        return $this->getEventSignRepository()->findBy('event_id', $eventId);
    }

    public function findSignsByUser($user_id)
    {
        return $this->getEventSignRepository()->findBy('user_id', $user_id);
    }

    public function findSignsByUserForFutureEvents($user_id)
    {
        return $this->getEventSignRepository()->findBy('user_event.user_id = ? AND event.date_to > ?', [$user_id, new Nette\Utils\DateTime()])->order('event.date_from ASC');
    }

    public function getSign($eventId, $userId)
    {
        return $this->getEventSignRepository()->getByEventUser($eventId, $userId);
    }

    public function deleteSign($eventId, $userId)
    {
        return $this->getEventSignRepository()->deleteForUser($eventId, $userId);
    }

    public function deleteSignsWithNoEventRelation()
    {
        return $this->getEventSignRepository()->deleteWithNoEventRelation();
    }
}