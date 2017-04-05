<?php
namespace App\Presenters;

use App\Model\ProfileRepository;
use Nette;
use App\Model;

abstract class BaseSecurePresenter extends BasePresenter
{
    /** @var ProfileRepository @inject */
    public $profileRepository;


    /** @var Model\EventFacade
     * @inject
     */
    public $eventFacade;

    /** @var Model\ThreadFacade
     * @inject
     */
    public $threadFacade;


    protected function startup()
    {
        parent::startup();

        $profile = $this->profileRepository->get($this->user->id);
        
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

        $this->template->unreadThreadsCount = $this->threadFacade->getUnreadThreadsCount($this->user->id);
        $this->template->unreadEventThreadsCount = $this->threadFacade->getUnreadThreadsCount($this->user->id, true);
        $this->template->readLaterThreadsCount = $this->threadFacade->getReadLaterThreadsCount($this->user->id);
        $this->template->readLaterEventThreadsCount = $this->threadFacade->getReadLaterThreadsCount($this->user->id, true);
        $this->template->newEventsCount = $this->eventFacade->getNewEventsCount($this->user->id);
        if ($this->user->isInRole(Model\PermissionRepository::MODIFY_USER))
            $this->template->awaitingApprovalCount = $this->profileRepository->findAwaitingApproval()->count();

        $profile->update(['last_activity' => null]);
    }

    protected function onlyWithPermission($permissionSlug)
    {
        if (!$this->user->isInRole($permissionSlug)) {
            throw new Nette\Application\ForbiddenRequestException();
        }
    }

}