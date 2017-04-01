<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 4. 12. 2016
 * Time: 17:37
 */

namespace App\Model;


use Nette\Utils\DateTime;

class ActivityRepository extends Repository
{
    protected $table = 'activity';

    public function trackActivity($userId, $threadId, $type = 'seen')
    {
        $activity = $this->findBy('user_id = ? AND thread_id = ?', array($userId, $threadId));
        if (!$activity->fetch()) {
            return $this->insert(['user_id' => $userId, 'thread_id' => $threadId, 'activity_type' => $type]);
        } else {
            return $activity->update(['last_activity' => new DateTime(), 'activity_type' => $type]);
        }
    }
}