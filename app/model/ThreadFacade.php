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


class ThreadFacade
{
    /** @var Database */
    public $database;

    /**
     * @var ThreadRepository
     */
    private $threadRepository;

    /** @var  PostRepository */
    private $postRepository;

    /** @var  ActivityRepository */
    private $activityRepository;

    /** @var  ProfileRepository */
    private $profileRepository;

    /** @var  LikeRepository */
    private $likeRepository;

    /** @var FileRepository */
    private $fileRepository;

    /** @var  EventSignRepository */
    private $eventSignRepository;

    /** @var  ReadLaterRepository */
    private $readLaterRepository;


    /** @var  ThreadRestrictionsRepository */
    private $threadRestrictionsRepository;

    private $notSeenIds;
    private $restrictedIds;


    /**
     * EventFacade constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }


    /*****************************
     * HELPERS
     ****************************/

    private function getThreadRepository()
    {
        if (!$this->threadRepository) {
            $this->threadRepository = new ThreadRepository($this->database);
        }
        return $this->threadRepository;
    }

    private function getPostRepository()
    {
        if (!$this->postRepository) {
            $this->postRepository = new PostRepository($this->database);
        }
        return $this->postRepository;
    }

    private function getActivityRepository()
    {
        if (!$this->activityRepository) {
            $this->activityRepository = new ActivityRepository($this->database);
        }
        return $this->activityRepository;
    }

    private function getThreadRestrictionsRepository()
    {
        if (!$this->threadRestrictionsRepository) {
            $this->threadRestrictionsRepository = new ThreadRestrictionsRepository($this->database);
        }
        return $this->threadRestrictionsRepository;
    }

    private function getProfileRepository()
    {
        if (!$this->profileRepository) {
            $this->profileRepository = new ProfileRepository($this->database);
        }
        return $this->profileRepository;
    }

    private function getLikeRepository()
    {
        if (!$this->likeRepository) {
            $this->likeRepository = new LikeRepository($this->database);
        }
        return $this->likeRepository;
    }

    private function getEventSignRepository()
    {
        if (!$this->eventSignRepository) {
            $this->eventSignRepository = new EventSignRepository($this->database);
        }
        return $this->eventSignRepository;
    }

    private function getReadLaterRepository()
    {
        if (!$this->readLaterRepository) {
            $this->readLaterRepository = new ReadLaterRepository($this->database);
        }
        return $this->readLaterRepository;
    }

    private function getFileRepository()
    {
        return $this->fileRepository;
    }

    public function setFileRepository(FileRepository $fileRepository) {
        $this->fileRepository = $fileRepository;
    }

    public function getNotSeenIds($userId, $refresh = false)
    {
        if (!$this->notSeenIds || $refresh) {
            $this->notSeenIds = $this->database->query("
            SELECT thread.id
                FROM thread
                  LEFT JOIN activity ON activity.thread_id = thread.id
                WHERE activity.user_id = ? AND last_post > activity.last_activity
            UNION
            SELECT thread_id as id
                FROM
                  activity
                WHERE thread_id NOT IN (
                  SELECT
                         thread.id
                       FROM thread
                         LEFT JOIN activity ON activity.thread_id = thread.id
                       WHERE activity.user_id = ?
                     )
            UNION 
            SELECT
                  thread.id
                FROM thread
                  LEFT JOIN activity ON activity.thread_id = thread.id
                WHERE activity.user_id IS NULL", $userId, $userId)->fetchPairs(null, 'id');
        }
        $this->notSeenIds[] = -1;
        return $this->notSeenIds;


    }

    public function getRestrictedIds($userId)
    {
        if (!$this->restrictedIds) {
            $this->restrictedIds = ($this->getThreadRestrictionsRepository()->findBy('user_id', $userId)->fetchPairs(null, 'thread_id'));
            $this->restrictedIds[] = -1;
        }

        return $this->restrictedIds;
    }

    /*****************************
     * THREAD
     ****************************/

    public function get($threadId)
    {
        return $this->getThreadRepository()->get($threadId);
    }

    public function addThread($userId, $title, $restrictUsers = "", $eventId = null)
    {
        $data = array('user_id'   => $userId,
                      'title'     => $title,
                      'event_id'  => $eventId == '' ? null : $eventId,
                      'last_post' => new Nette\Utils\DateTime());

        $threadId = $this->getThreadRepository()->insert($data);

        $this->addRestrictionsSerialized($threadId, $restrictUsers);

        $this->trackActivity($userId, $threadId, "created");

        return $threadId;
    }

    public function deleteThread($threadId)
    {
        $postIds = $this->getPosts($threadId)->fetchPairs(null, 'id');
        $this->getFileRepository()->deleteByObject($threadId, 'thread');
        $this->getFileRepository()->deleteByObjectMulti($postIds, 'post');

        $this->getThreadRepository()->get($threadId)->delete();
    }

    public function update($threadId, $values, $restrictionsSerialized)
    {
        $this->get($threadId)->update($values);

        $this->addRestrictionsSerialized($threadId, $restrictionsSerialized);
    }

    public function archive($threadId)
    {
        return $this->get($threadId)->update(['archived' => 1]);
    }

    public function removeFromArchive($threadId)
    {
        $this->get($threadId)->update(['archived' => 0]);
    }

    public function togglePinned($threadId)
    {
        $thread = $this->get($threadId);

        $set = true;
        if ($thread->pinned) {
            $set = false;
        }

        $thread->update(['pinned' => $set]);
        return $set;
    }

    /*****************************
     * POSTS
     ****************************/
    public function getPosts($threadId)
    {
        return $this->getPostRepository()->findBy('thread_id', $threadId)->order('path ASC');
    }

    public function getPost($postId)
    {
        return $this->getPostRepository()->get($postId);
    }

    public function addPost($userId, $threadId, $content, $parentId = null)
    {
        $id = $this->getPostRepository()->add($userId, $threadId, $content, $parentId);

        $this->getThreadRepository()->get($threadId)->update(['last_post' => new Nette\Utils\DateTime()]);

        $this->trackActivity($userId, $threadId, "posted");

        return $id;
    }

    public function deletePost($postId)
    {
        $this->getFileRepository()->deleteByObject($postId,'post');

        $post = $this->getPostRepository()->get($postId);
        $thread = $this->getThreadRepository()->get($post->thread_id);
        $threadId = $post->thread_id;
        if ($this->getPostRepository()->findBy('parent_id', $post->id)->count() > 0) {
            $post->update(['deleted' => time()]);
        } else {
            $post->delete();
        }

        $lastPost = $this->getPostRepository()->findBy('id != ? AND thread_id = ?', [$postId, $threadId])
            ->order('created_at DESC')->limit(1)->fetch()->created_at;
//        dump($lastPost);
        $thread->update(['last_post' => $lastPost]);
    }

    public function updatePost($postId, $values)
    {
        $post = $this->getPostRepository()->get($postId);

        unset($values['thread_id']);
        unset($values['post_id']);

        return $post->update($values);
    }

    public function toggleReadLater($postId, $userId)
    {
        $post = $this->getPostRepository()->get($postId);

        $existing = $this->getReadLaterRepository()->findBy('post_id = ? AND user_id = ?', [$postId, $userId]);

        if ($existing->count() > 0) {
            $existing->delete();
        } else {
            $this->getReadLaterRepository()->insert([
                'post_id'   => $postId,
                'user_id'   => $userId,
                'thread_id' => $post->thread_id]);
        }
    }

    public function findReadLaterIds($userId, $threadId = null)
    {

        if ($threadId) {
            $selection = $this->getReadLaterRepository()->findBy('thread_id = ? AND user_id = ?', [$threadId, $userId]);
        } else {
            $selection = $this->getReadLaterRepository()->findBy('user_id', $userId);
        }

        return $selection->fetchPairs(null, 'post_id');
    }

    /*****************************
     * FIND THREADS
     ****************************/

    public function findAll($userId, $orderBy = ThreadRepository::BY_DATE_LAST_POST, $limit = null, $offset = null,
                            $includeArchive = false, $onlyArchive = false, $withEvents = false, $onlyEvents = false)
    {
        $orderFunc = ThreadRepository::getOrderFunction($orderBy);
        $selection = $this->getThreadRepository()
            ->findBy('id NOT IN', $this->getRestrictedIds($userId));
        if (!$includeArchive) $selection = $selection->where('archived = 0');
        if ($onlyArchive) $selection = $selection->where('archived = 1');
        if (!$withEvents) $selection = $selection->where('event_id IS NULL');
        if ($onlyEvents) $selection = $selection->where('event_id IS NOT NULL');
        return $orderFunc($selection)->limit($limit, $offset);
    }

    public function findByEventId($userId, $eventId)
    {
        return $this->getThreadRepository()
            ->findBy('event_id = ? AND id NOT IN ?', [$eventId, $this->getRestrictedIds($userId)]);
    }

    public function findForFutureEvents($userId, $limit = null, $offset = null)
    {
        $rejectedEventIds = $this->getEventSignRepository()->findBy('user_id = ? AND type = ?', [$userId, SignEnum::NO])->fetchPairs(null, 'event_id');
        $rejectedEventIds[] = -1;

        return $this->getThreadRepository()
            ->findBy('thread.id NOT IN (?) AND event.date_to > ? AND event.id NOT IN ?',
                [$this->getRestrictedIds($userId), new Nette\Utils\DateTime(), $rejectedEventIds])->limit($limit, $offset);
    }

    public function findDashboard($userId, $orderBy = ThreadRepository::BY_DATE_LAST_POST)
    {
        $orderFunc = ThreadRepository::getOrderFunction(ThreadRepository::BY_DATE_LAST_POST);
        return $orderFunc($this->getThreadRepository()
            ->findBy('event_id IS NULL AND archived = 0 AND id NOT IN ?', $this->getRestrictedIds($userId)));
    }

    /**
     * @param $userId
     * @param bool $withPinned
     * @return Nette\Database\Table\Selection
     */
    public function findNotSeen($userId, $withPinned = false)
    {
        $orderFunc = ThreadRepository::getOrderFunction(ThreadRepository::BY_DATE_LAST_POST);
        $selection = $this->getThreadRepository()
            ->findBy('event_id IS NULL AND id IN (?) AND id NOT IN ?', [$this->getNotSeenIds($userId), $this->getRestrictedIds($userId)]);
        $selection = $selection->where('archived = 0');
        if (!$withPinned) $selection = $selection->where('pinned = 0');
        return $orderFunc($selection);
    }

    public function findSeen($userId, $withPinned = false)
    {
        $orderFunc = ThreadRepository::getOrderFunction(ThreadRepository::BY_DATE_LAST_POST);
        $selection = $this->getThreadRepository()
            ->findBy('event_id IS NULL AND id NOT IN (?) AND id NOT IN ?', [$this->getNotSeenIds($userId), $this->getRestrictedIds($userId)]);
        $selection = $selection->where('archived = 0');
        if (!$withPinned) $selection = $selection->where('pinned = 0');
        return $orderFunc($selection);
    }

    public function findPinned($userId)
    {
        $orderFunc = ThreadRepository::getOrderFunction(ThreadRepository::BY_DATE_LAST_POST);
        $selection = $this->getThreadRepository()
            ->findBy('pinned = 1 AND event_id IS NULL AND id NOT IN ?', $this->getRestrictedIds($userId));
        $selection = $selection->where('archived = 0');
        return $orderFunc($selection);
    }


    /*****************************
     * UNREAD COUNTS
     ****************************/

    public function getUnreadThreadsCount($userId, $events = false, $countRejected = false)
    {
        if ($events) {
            $threads = $this->findForFutureEvents($userId)
                ->where('thread.id IN (?) AND thread.id NOT IN ?', [$this->getNotSeenIds($userId), $this->getRestrictedIds($userId)]);

        } else {
            $threads = $this->findNotSeen($userId, true);
        }
        return $threads->count();
//VERSION 2
//        $count = 0;
//        $threadIds = $threads->fetchPairs(null,'id'); $threadIds[] = -1;
//        $lastVisited = $this->getActivityRepository()->findBy('user_id = ? AND thread_id IN ?',[$userId,$threadIds])
//            ->fetchPairs('thread_id', 'last_activity');
//        dump($lastVisited);
//        dump($threadIds);
//        dump(array_key_exists("149",$lastVisited));
//        foreach ($threads as $thread) {
//
//            if (!array_key_exists($thread->id,$lastVisited)) {
//                dump($thread->id);
//                $count += 1;
//                continue;
//            }
//            $lastVisited = $lastVisited[$thread->id];
//
//            if ($thread->last_post > $lastVisited) {
//                $count += 1;
//            }
//        }
//
//        return $count;
//VERSION1
//        $count = 0;
//
//        foreach ($threads as $thread) {
//            $lastVisited = $this->getActivityRepository()->findBy('user_id = ? AND thread_id = ?', [$userId, $thread->id])
//                ->fetchPairs(null, 'last_activity');
//
//            if (empty($lastVisited)) {
//                $count += 1;
//                continue;
//            }
//            $lastVisited = $lastVisited[0];
//
//            if ($thread->last_post > $lastVisited) {
//
//                $count += 1;
//            }
//        }
//
//        return $count;
    }

    public function getReadLaterCounts($userId)
    {
        return $this->getReadLaterRepository()->findBy('user_id', $userId)->group('thread_id')->select('thread_id, count(*) AS count')->fetchPairs('thread_id', 'count');
    }

    public function getReadLaterThreadsCount($userId, $events = false)
    {
        $threadIds = array_keys($this->getReadLaterCounts($userId));
        if ($events) {
            $threads = $this->findForFutureEvents($userId);
        } else {
            $threads = $this->findDashboard($userId);
        }
        $threads = $threads->where('thread.id IN (?) AND thread.id NOT IN ?', [$threadIds, $this->getRestrictedIds($userId)]);
        return $threads->count();
    }

    public function getUnreadPostsAllThreadsCount($userId)
    {

        $threads = $this->getThreadRepository()->findAll();

        $count = 0;
        foreach ($threads as $thread) {
            $count += $this->getUnreadPostsOnThreadCount($userId, $thread->id);
        }
        return $count;

    }

    public function getUnreadPostsOnThreadCount($userId, $threadId)
    {
        $count = 0;
        $lastVisited = $this->getActivityRepository()->findBy('user_id = ? AND thread_id = ?', [$userId, $threadId])
            ->fetchPairs(null, 'last_activity');

        if (empty($lastVisited)) {
            $lastVisited = [(new Nette\Utils\DateTime())->setDate(1970, 1, 1)];
            $count += 1;
        }
        $lastVisited = $lastVisited[0];

        //$readLaterIds = $this->findReadLaterIds($userId,$threadId);

        return $count + $this->getPostRepository()->findBy('(thread_id = ? AND created_at > ?)', [$threadId, $lastVisited])->count();
    }

    public function getUnreadPostsCounts($userId, $threadIds)
    {
        $unreads = [];
        foreach ($threadIds as $threadId) {
            $unreads[$threadId] = $this->getUnreadPostsOnThreadCount($userId, $threadId);
        }

        return $unreads;
    }

    public function getUnreadPostsCountsBySelection($userId, Nette\Database\Table\Selection $threadsSelection)
    {
        $ids = $threadsSelection->fetchPairs(null, 'id');
        return $this->getUnreadPostsCounts($userId, $ids);
    }

    /*****************************
     * ACTIVITY
     ****************************/

    public function trackActivity($userId, $threadId, $activityType = "seen")
    {
        $this->getActivityRepository()->trackActivity($userId, $threadId, $activityType);
    }

    public function findActivityByUser($userId)
    {
        return $this->getActivityRepository()->findBy('user_id', $userId);
    }

    public function findActivityDateByThread($userId, $threadId)
    {
        $activity = $this->getActivityRepository()->findBy('user_id = ? AND thread_id = ?', [$userId, $threadId])->fetch();
        if (!$activity) return (new Nette\Utils\DateTime())->setDate(1970, 1, 1);

        return $activity->last_activity;
    }

    public function findActivityByThread($threadId)
    {
        return $this->getActivityRepository()->findBy('thread_id = ?', $threadId)->order('last_activity DESC');
    }

    /*****************************
     * RESTRICTIONS
     ****************************/
    public function deleteRestrictions($threadId)
    {
        $this->getThreadRestrictionsRepository()->findBy('thread_id', $threadId)->delete();
    }

    public function addRestrictionsSerialized($threadId, $serializedUserIds)
    {
        $this->deleteRestrictions($threadId);

        $userIds = preg_split("/[;,]/", $serializedUserIds);

        foreach ($userIds as $id) {
            $this->addRestriction($threadId, $id);
        }
    }

    public function addRestriction($threadId, $userId)
    {
        if (preg_match("/[0-9]+/", $userId)) {
            $this->getThreadRestrictionsRepository()->insert(
                ['thread_id' => $threadId, 'user_id' => $userId]);
        }
    }

    public function getRestrictionsSerialized($threadId)
    {
        $restrictions = $this->getThreadRestrictionsRepository()->findBy('thread_id', $threadId)->fetchPairs(null, 'user_id');
        return implode(',', $restrictions);
    }

    public function findRestrictionsForThread($threadId)
    {
        return $this->getThreadRestrictionsRepository()->findBy('thread_id', $threadId);
    }

    /*****************************
     * LIKES
     ****************************/

    public function toggleLike($postId, $userId)
    {
        $like = $this->getLikeRepository()->findBy('post_id = ? AND user_id = ?', [$postId, $userId]);

        if ($like->count() > 0) {
            $like->delete();
        } else {
            $this->getLikeRepository()->insert(['post_id' => $postId, 'user_id' => $userId]);
        }

        $this->updateLikeCountCache($postId);
    }

    public function updateLikeCountCache($postId)
    {
        $likeCount = $this->getLikeRepository()->findBy('post_id', $postId)->count();

        $this->getPostRepository()->get($postId)->update(['like_count' => $likeCount]);
    }

    public function getUserLikes($userId, $threadId)
    {
        return $this->getLikeRepository()->findBy('like.user_id = ? AND post.thread_id = ?', [$userId, $threadId])->fetchPairs('post_id', 'post_id');
    }

    public function getPostLikes($postId)
    {
        return $this->getLikeRepository()->findBy('post_id', $postId);
    }

}