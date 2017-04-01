<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 13. 8. 2016
 * Time: 20:47
 */

namespace App\Model;


class EventSignRepository extends Repository
{
    protected $table = 'user_event';

    public function getByEventUser($eventId, $userId)
    {
        return $this->findBy('event_id = ? AND user_id = ?', array($eventId, $userId))->fetch();
    }


    public function deleteForUser($eventId, $userId)
    {
        return $this->findBy('event_id = ? AND user_id = ?', array($eventId, $userId))->delete();
    }

    public function deleteWithNoEventRelation()
    {
        $this->database->query('
            DELETE FROM user_event
            WHERE ID IN (SELECT * FROM (SELECT id
                         FROM user_event
                         WHERE user_event.role_id NOT IN (SELECT event_role.role_id
                                                          FROM event_role
                                                          WHERE event_role.event_id = user_event.event_id))as t);
            ');
    }
}