<?php
namespace App\Presenters;

use App\Model\ProfileRepository;
use Nette;
use App\Model;
use App\Model\EventRepository;

abstract class BaseSecurePresenter extends BasePresenter
{
    /** @var ProfileRepository @inject */
    public $profileRepository;

    /** @var Model\FileRepository @inject */
    public $fileRepository;


    /** @var Model\EventFacade
     * @inject
     */
    public $eventFacade;

    /** @var Model\ThreadFacade
     * @inject
     */
    public $threadFacade;

    /** @var Model\CronManager
     * @inject
     */
    public $cronManager;

    protected function startup()
    {
        parent::startup();
        $this->fileRepository->setImageStorage($this->imageStorage);
        $this->threadFacade->setFileRepository($this->fileRepository);
        $profile = $this->profileRepository->get($this->user->id);
        $this->cronManager->check();
        
        if ($profile['logout']) {
            $this->user->logout(true);
            $profile->update(['logout' => false]);
        }

        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:default', array('backlink' => $this->storeRequest()));
        }

        if ($profile['registration_token']) {
            $this->flashMessage('Nejprve zkontroluj email a klikni na odkaz pro ověření účtu.', 'warning');
            $this->redirect('Sign:default');
        }

        if (!$this->user->isInRole('member')) {
            $dest = 'Homepage:default';
            if (!$this->isLinkCurrent($dest))
                $this->redirect($dest);
            $this->flashMessage('Nestihli jsme tě ještě schválit, vydrž!', 'warning');
        }

        $this->template->readLaterEventThreadsCount = 
            $this->threadFacade->getReadLaterThreadsCount($this->user->id, true);
        $this->template->newPublicEventsCount = $cEvPub = 
            $this->eventFacade->getNewEventsCount($this->user->id, EventRepository::EVENT_PUBLIC);
        $this->template->newEduEventsCount = $cEvEdu = 
            $this->eventFacade->getNewEventsCount($this->user->id, EventRepository::EVENT_EDUCATION);
        $c3 = $cEvPub + $cEvEdu;

        $this->template->unreadThreadsCount = $c1 = $this->threadFacade->getUnreadThreadsCount($this->user->id);
        $this->template->unreadEventThreadsCount = $c2 = $this->threadFacade->getUnreadThreadsCount($this->user->id, true);
        $this->template->readLaterThreadsCount = $this->threadFacade->getReadLaterThreadsCount($this->user->id);

        $this->template->newCount = $c1 + $c2 + $c3;
        if ($this->user->isInRole(Model\PermissionRepository::MODIFY_USER)){
            $this->template->awaitingApprovalCount = $c4 = $this->profileRepository->findAwaitingApproval()->count();
            $this->template->newCount = $c1 + $c2 + $c3 + $c4;
        }


        $profile->update(['last_activity' => null]);
    }

    protected function onlyWithPermission($permissionSlug)
    {
        if (!$this->user->isInRole($permissionSlug)) {
            throw new Nette\Application\ForbiddenRequestException();
        }
    }

}