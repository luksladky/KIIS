<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 9. 8. 2016
 * Time: 18:13
 */

namespace App\Presenters;

use App\Forms\AddPostFormFactory;
use App\Forms\EditThreadFormFactory;
use App\Forms\EditPostFormFactory;
use Nette;
use App\Model;
use App\Forms\AddThreadFormFactory;
use App\Model\PermissionRepository as Permission;


class ThreadPresenter extends BaseSecurePresenter
{
    /** @var Model\ThreadFacade
     * @inject
     */
    public $threadFacade;

    /** @var \Texy\Texy @inject */
    public $texy;

    public function renderDefault()
    {
        $this->template->threadsPinned = $threadsPinned = $this->threadFacade->findPinned($this->user->id);
        $this->template->threadsNotSeen = $threadsNotSeen = $this->threadFacade->findNotSeen($this->user->id);
        $this->template->threadsSeen = $threadsSeen = $this->threadFacade->findSeen($this->user->id);

        $this->template->unreadCounts =
            $this->threadFacade->getUnreadPostsCountsBySelection($this->user->id, $threadsNotSeen) +
            $this->threadFacade->getUnreadPostsCountsBySelection($this->user->id, $threadsPinned);

        $this->template->readLaterCounts = $this->threadFacade->getReadLaterCounts($this->user->id);

    }

    public function renderArchive($dashboard = true, $events = false)
    {
        $withEvents = $events;
        $onlyEvents = !$dashboard && $events;

        $threads = $this->threadFacade
            ->findAll($this->user->id, Model\ThreadRepository::BY_DATE_LAST_POST, null, null, true, true,
                $withEvents, $onlyEvents);
        $this->template->threads = $threads;
        $this->template->unreadCounts = $this->threadFacade->getUnreadPostsCountsBySelection($this->user->id, $threads);

        $this->template->withEvents = $withEvents;
        $this->template->onlyEvents = $onlyEvents;
    }

    public function renderEventThreads($all = false, $unreadFirst = true)
    {

        //archiv si muzeme najit primo u akce
        if (!$all)
            $events = $this->eventFacade->findFutureNotRejected($this->user->id, Model\EventRepository::BY_DATE_FROM, false);
        else
            $events = $this->eventFacade->findFuture(Model\EventRepository::BY_DATE_FROM, false);

        $threads = [];
        $threadIds = [];
        $eventThreadIds = [];
        foreach ($events as $event) {
            $threads[$event->id] = $this->threadFacade->findByEventId($this->user->id, $event->id);
            foreach ($threads[$event->id] as $thread) {
                $threadIds[] = $thread->id;
            }
        }
        $unreadCounts = $this->threadFacade->getUnreadPostsCounts($this->user->id, $threadIds);


        if ($unreadFirst) {
            $eventsWithUnread = [];
            $eventsWithAllRead = [];
            foreach ($events as $event) {
                $withUnreadThreads = false;
                foreach ($threads[$event->id] as $thread) {
                    if ($unreadCounts[$thread->id] > 0) {
                        $withUnreadThreads = true;
                        break;
                    }
                }
                if ($withUnreadThreads) $eventsWithUnread[] = $event;
                else $eventsWithAllRead[] = $event;
            }
            $events = array_merge($eventsWithUnread, $eventsWithAllRead);
        }

        $this->template->futureEvents = $events;
        $this->template->threads = $threads;
        $this->template->unreadCounts = $unreadCounts;
        $this->template->readLaterCounts = $this->threadFacade->getReadLaterCounts($this->user->id);
        $this->template->all = $all;
        $this->template->unreadFirst = $unreadFirst;
    }

    public function renderShow($id)
    {
        if (in_array($id, $this->threadFacade->getRestrictedIds($this->user->id))) {
            $this->flashMessage('Tohle je pro tebe bohužel skryté.', 'danger');
            $this->redirect('Thread:default');
        }

        $this->template->thread = $thread = $this->threadFacade->get($id);
        if (!$thread) {
            $this->flashMessage('Diskuse byla nejspíš smazána.', 'warning');
            $this->redirect('Thread:default');
        }
        $this->template->userCanEdit = $this->userCanEdit($thread->user_id);
        $posts = $this->threadFacade->getPosts($id);
        if (!isset($this->template->posts)) {
            $this->template->posts = $posts;
        }
        $this->template->userLikes = $this->threadFacade->getUserLikes($this->user->id, $id);
        $this->template->lastActivity = $lastActivity = $this->threadFacade->findActivityDateByThread($this->user->id, $id);
        $this->template->restrictions = $this->threadFacade->findRestrictionsForThread($id);
        $this->template->allActivity = $this->threadFacade->findActivityByThread($id);
        $this->template->readLaterIds = $readLaterIds = $this->threadFacade->findReadLaterIds($this->user->id, $id);

        $lastReadPostId = -1;
        $lastReadPost = null;
        $iterator = 0;
        foreach ($posts as $post) {
            if ($post->created_at > $lastActivity) {
                break;
            }
            if (in_array($post->id, $readLaterIds)) {
                break;
            }
            $lastReadPostId = $post->id;
            $lastReadPost = $post;
            $iterator++;
        }
        $hiddenReadPostsCount = $iterator - 1;
        //chci to dat na rodice
        if ($lastReadPost && $lastReadPost->parent_id) $lastReadPostId = $lastReadPost->parent_id;

        //pokud jsou prectene vsechny, nebo pokud je jich celkove malo, neskryvat
        if ($iterator == $posts->count() || $hiddenReadPostsCount < 5) $lastReadPostId = -1;

        $this->template->lastReadPostId = $lastReadPostId;
        $this->template->readPostsCount = $hiddenReadPostsCount;

        $this['addPostForm']->setDefaults(['thread_id' => $id]);
        $this->threadFacade->trackActivity($this->user->id, $id, 'seen');
    }

    public function actionEdit($id)
    {
        $thread = $this->threadFacade->get($id);

        if (!$thread) {
            throw new Nette\Application\BadRequestException();
        }


        if (!$this->userCanEdit($thread->user_id)) {
            throw new Nette\Application\ForbiddenRequestException();
        }

        $this->template->threadId = $id;

        $this['editThreadForm']->setDefaults(
            ['thread_id'      => $id,
             'title'          => $thread->title,
             'event_id'       => $thread->event_id,
             'restrict_users' => $this->threadFacade->getRestrictionsSerialized($id),
            ]);
    }

    public function actionEditPost($id)
    {


        $post = $this->threadFacade->getPost($id);


        if (!$post) {
            throw new Nette\Application\BadRequestException();
        }


        if (!($this->user->id == $post->user_id)) {
            throw new Nette\Application\ForbiddenRequestException();
        }

        $this->template->threadId = $post->thread_id;
        $this->template->postId = $id;

        $this['editPostForm']->setDefaults(
            ['post_id'   => $id,
             'thread_id' => $post->thread_id,
             'content'   => $post->content,
            ]);
    }


    public function createComponentAddThreadForm()
    {
        $form = (new AddThreadFormFactory())->create();

        $form->onSuccess[] = array($this, 'addThreadFormSucceeded');

        return $form;
    }

    public function addThreadFormSucceeded($form, $values)
    {
        $this->onlyWithPermission(Permission::ADD_THREAD);

        $values['title'] = str_replace('<p>&nbsp;</p>', '', $values['title']);
        $values['title'] = str_replace('<p></p>', '', $values['title']);
        $values['title'] = $this->texy->process($values['title']);

        $this->threadFacade->addThread($this->user->id, $values['title'], $values['restrict_users'], $values['event_id']);

        $this->flashMessage('Diskuse je na světě.', 'success');
    }

    public function createComponentEditThreadForm()
    {
        $form = (new EditThreadFormFactory())->create();

        $form->onSuccess[] = array($this, 'editThreadFormSucceeded');

        return $form;
    }

    public function editThreadFormSucceeded($form, $values)
    {
        $values['title'] = $this->texy->process($values['title']);

        $threadId = $values['thread_id'];
        $restrictions = $values['restrict_users'];
        unset($values['restrict_users']);
        unset($values['thread_id']);
        if ($values['event_id'] == '') unset($values['event_id']);

        $this->threadFacade->update($threadId, $values, $restrictions);

        $this->flashMessage('A je to.', 'success');

        $this->redirect('Thread:show', $threadId);
    }

    public function createComponentEditPostForm()
    {
        $form = (new EditPostFormFactory())->create();

        $form->onSuccess[] = array($this, 'editPostFormSucceeded');

        return $form;
    }

    public function editPostFormSucceeded($form, $values)
    {
        $values['content'] = str_replace('<p>&nbsp;</p>', '', $values['content']);
        $values['content'] = str_replace('<p></p>', '', $values['content']);
        $values['content'] = $this->texy->process($values['content']);


        $postId = $values['post_id'];
        $threadId = $values['thread_id'];
        unset($values['post_id']);
        unset($values['thread_id']);

        $this->threadFacade->updatePost($postId, $values);

        $this->flashMessage('A je to, příspěvěk máš upravený. Tadá. Bomba.', 'success');

        $this->redirect('Thread:show#post-' . $postId, $threadId);


    }

    public function createComponentAddPostForm()
    {
        $form = (new AddPostFormFactory())->create();

        $form->onSuccess[] = array($this, 'addPostFormSucceeded');

        return $form;
    }

    public function addPostFormSucceeded($form, $values)
    {
        $values['content'] = str_replace('<p>&nbsp;</p>', '', $values['content']);
        $values['content'] = str_replace('<p></p>', '', $values['content']);
        $values['content'] = $this->texy->process($values['content']);


        $id = $this->threadFacade->addPost($this->user->id, $values['thread_id'], $values['content'], $values['parent']);

        $this->redirect('this#post-' . $id);
    }

    public function handleDeletePost($postId)
    {
        $post = $this->threadFacade->getPost($postId);

        if (!$post) {
            throw new Nette\Application\BadRequestException();
        }

        if (!$this->userCanEditPost($post->user_id)) {
            throw new Nette\Application\ForbiddenRequestException();
        }

        $this->threadFacade->deletePost($postId);
        $this->flashMessage('Příspěvek smazán.', 'success');
        $this->redirect('this');
    }


    public function handleDeleteThread($threadId)
    {
        $thread = $this->threadFacade->get($threadId);

        if (!$thread) {
            throw new Nette\Application\BadRequestException();
        }

        if (!$this->userCanEdit($thread->user_id)) {
            throw new Nette\Application\ForbiddenRequestException();
        }

        $this->threadFacade->deleteThread($threadId);

        $this->redirect('Thread:default');
    }

    public function handleArchiveThread($threadId)
    {
        $thread = $this->threadFacade->get($threadId);

        if (!$thread) {
            throw new Nette\Application\BadRequestException();
        }

        if (!$this->userCanEdit($thread->user_id)) {
            throw new Nette\Application\ForbiddenRequestException();
        }

        $this->threadFacade->archive($threadId);

        $this->flashMessage('Diskuse archivována.', 'success');
        $this->redirect('this');
    }

    public function handleRemoveThreadFromArchive($threadId)
    {
        $thread = $this->threadFacade->get($threadId);

        if (!$thread) {
            throw new Nette\Application\BadRequestException();
        }

        if (!$this->userCanEdit($thread->user_id)) {
            throw new Nette\Application\ForbiddenRequestException();
        }

        $this->threadFacade->removeFromArchive($threadId);

        $this->flashMessage('Diskuse je zase ve hře.', 'success');
        $this->redirect('this');
    }

    public function handleToggleLike($postId)
    {
        $this->threadFacade->toggleLike($postId, $this->user->id);

        $this->payload->redirect = $this->presenter->link('this');
        $this->template->posts = [$this->threadFacade->getPost($postId)];
        $this->redrawControl('postWrapper');
    }


    public function handleTogglePinned($threadId)
    {
        if (!$this->user->isInRole(Permission::MANAGE_THREADS)) {
            throw new Nette\Application\ForbiddenRequestException();
        }

        $set = $this->threadFacade->togglePinned($threadId);

        if ($set)
            $this->flashMessage('Diskuse je připnuta nahoru.', 'success');
        else
            $this->flashMessage('Diskuse odepnuta.', 'success');
        $this->redirect('this');
    }

    public function handleToggleReadLater($postId)
    {
        $this->threadFacade->toggleReadLater($postId, $this->user->id);

        $this->payload->redirect = $this->presenter->link('this');
        $this->threadFacade->getNotSeenIds($this->user->id, true);

        $this->template->posts = [$this->threadFacade->getPost($postId)];
        $this->template->unreadThreadsCount = $this->threadFacade->getUnreadThreadsCount($this->user->id);
        $this->template->unreadEventThreadsCount = $this->threadFacade->getUnreadThreadsCount($this->user->id, true);
        $this->template->readLaterThreadsCount = $this->threadFacade->getReadLaterThreadsCount($this->user->id);
        $this->template->readLaterEventThreadsCount = $this->threadFacade->getReadLaterThreadsCount($this->user->id, true);

        $this->redrawControl('postWrapper');
        $this->redrawControl('badgeEventThreads');
        $this->redrawControl('badgeDashboard');
//        $this->redirect('this#post-' . $postId);
    }

    public function userCanEdit($threadAuthorId)
    {
        return ($this->user->isInRole(Permission::MANAGE_THREADS) || $this->user->id == $threadAuthorId);
    }

    public function userCanEditPost($postAuthorId)
    {
        return ($this->user->isInRole(Permission::MANAGE_THREADS) || $this->user->id == $postAuthorId);
    }
}