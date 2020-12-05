<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 10. 8. 2016
 * Time: 14:02
 */

namespace App\Presenters;

use Nette;
use App\Model;
use App\Forms\ChangePasswordFormFactory;
use App\Forms\EditUserFormFactory;
use Nette\Database\Context as Database;


class ProfilePresenter extends BaseSecurePresenter
{
    /** @var Model\ProfileRepository @inject */
    public $profileRepository;

    /** @var Model\EventFacade @inject */
    public $eventFacade;

    /** @var Model\UserManager @inject */
    public $userManager;


    /** @var Model\PermissionRepository @inject */
    public $permissionRepository;


    public function renderDefault($order = 'last_activity')
    {

        switch ($order) {
            case 'last_activity':
                $orderBy = 'last_activity DESC';
                break;
            case 'nickname':
                $orderBy = 'nickname ASC';
                break;
            default:
                $orderBy = 'name ASC';
        }

        $withMemberRole = $this->permissionRepository->findBy("permission_slug LIKE ?", "member")->fetchPairs(null, 'user_id');
        $this->template->profiles = $this->profileRepository->findBy('id IN ? ', $withMemberRole)->order($orderBy);
        $this->template->order = $order;
    }

    public function renderShow($id)
    {
        if (!$id) $id = $this->user->id;

        $person = $this->profileRepository->get($id);

        if (!$person) {
            throw new Nette\Application\BadRequestException;
        }

        $this->template->userCanEdit = $this->userCanEditProfile($id);
        $this->template->profile = $person;
        $this->template->eventSigns = $this->eventFacade->findSignsByUserForFutureEvents($id);
    }

    public function actionEdit($userId)
    {
        $person = $this->profileRepository->get($userId);

        if (!$person) {
            throw new Nette\Application\BadRequestException;
        }

        if (!$this->userCanEditProfile($userId)) {
            throw new Nette\Application\ForbiddenRequestException;
        }

        $defaults = array(
            'id'             => $userId,
            'name'           => $person['name'],
            'nickname'       => $person['nickname'],
            'phone'          => $person['phone'],
            'city'           => $person['city'],
            'tshirt_size'    => $person['tshirt_size'],
            'upcoming_notif' => $person['upcoming_notif'],
        );

        $this['editForm']->setDefaults($defaults);

        $this->template->profile = $person;

        if ($this->isAjax()) {
            $this->redrawControl('profilePhoto');
        }
    }

    public function actionChangePassword()
    {
        if (!$this->user->isLoggedIn()) {
            throw new Nette\Application\ForbiddenRequestException();
        }
        $id = $this->user->id;

        $user = $this->profileRepository->get($id);

        $this->template->userHasPassword = isset($user->hash) && $user->hash != '';
    }


    public function actionEditAllPermissions()
    {
        $this->onlyWithPermission(Model\PermissionRepository::MODIFY_USER);

        $this->template->profiles = $profiles = $this->profileRepository->findAll()->order('nickname ASC');
        $this->template->allRoles = $this->permissionRepository->findPermissions();
        $this->template->assignedRoles = $this->getAssignedRoles($profiles);
        $this->template->awaitingApproval = $this->profileRepository->findAwaitingApproval();

    }

    public function actionEditPermissions($userId)
    {
        $this->onlyWithPermission(Model\PermissionRepository::MODIFY_USER);

        $this->template->profile = $this->profileRepository->get($userId);
        $this->template->allRoles = $this->permissionRepository->findPermissions();
        $this->template->assignedRoles = $this->permissionRepository->findByUser($userId);
    }

    /********** COMPONENTS ************/

    public function createComponentEditForm()
    {
        $form = (new EditUserFormFactory())->create();

        $form->onSuccess[] = array($this, 'editUserFormSucceeded');

        return $form;
    }

    public function editUserFormSucceeded($form, $values)
    {
        $id = $values['id'];

        if (!$this->userCanEditProfile($id)) {
            throw new Nette\Security\AuthenticationException("Ty ty ty, to nemůžeš.");
        }
        $data = array(
            "name"           => $values["name"],
            "nickname"       => $values["nickname"],
            "phone"          => $values['phone'],
            "city"           => $values['city'],
            "tshirt_size"    => $values['tshirt_size'],
            "upcoming_notif" => $values['upcoming_notif'],
        );


        /** @var Nette\Http\FileUpload $uploadedPhoto */
        $uploadedPhoto = $values['photo'];
        if ($uploadedPhoto->isImage()) {
            //delete old photo
            $this->imageStorage->delete(Model\ProfileRepository::IMAGE_NAMESPACE . "/" . $id . '_profile.jpg');

            $photo = $this->imageStorage->createImage();
            $photo->setName($id . '_profile.jpg')
                ->setNamespace(Model\ProfileRepository::IMAGE_NAMESPACE)
                ->saveUpload($uploadedPhoto);
            $data['photo'] = (string)$photo;
            $this->user->identity->photo = (string)$photo;
        }
        $this->user->identity->nickname = $values['nickname'];
        $this->user->identity->name = $values['name'];


        $this->profileRepository->get($id)->update($data);

        $this->flashMessage('Uloženo!', 'success');

        $this->redirect('Profile:show', $id);
    }

    public function createComponentChangePasswordForm()
    {
        $form = (new ChangePasswordFormFactory(true))->create();
        $form->onSuccess[] = array($this, 'changePasswordFormSucceeded');
        return $form;
    }

    public function createComponentSetPasswordForm()
    {
        $form = (new ChangePasswordFormFactory(false))->create();
        $form->onSuccess[] = array($this, 'changePasswordFormSucceeded');
        return $form;
    }


    /**Change password or set new if there was none (user logged by FB)
     * @param $form
     * @param $values
     * @throws Nette\Application\ForbiddenRequestException
     */
    public function changePasswordFormSucceeded($form, $values)
    {
        if (!$this->user->isLoggedIn()) {
            throw  new Nette\Application\ForbiddenRequestException('Please log in.');
        }

        $oldPassword = isset($values['oldPassword']) ? $values['oldPassword'] : null;

        if ($this->userManager->changePassword($this->user->id, $values['password'], $oldPassword)) {
            $this->flashMessage('Heslo máš nastavené, zbytek je ok? :-)', 'success');
            $this->redirect('Profile:edit', $this->user->id);
        } else {
            if (isset($oldPassword))
                $this->flashMessage('Špatně jsi napsat staré heslo :-(', 'danger');
            else
                $this->flashMessage('Nevím co, ale něco je špatně :-(', 'danger');
            $this->redirect('Profile:changePassword');
        }
    }


    /**Gets user id and returns if logged user can edit this users profile.
     * @param int $id
     * @return bool
     */
    private function userCanEditProfile($id)
    {
        return ($this->user->id == $id || $this->user->isInRole('modify-user'));
    }

    /**Deletes user profile photo.
     * @param int $id
     * @throws Nette\Application\ForbiddenRequestException
     */
    public function handleDeleteProfilePicture($id)
    {
        if (!$this->userCanEditProfile($id)) {
            throw new Nette\Application\ForbiddenRequestException('You cannot delete the photo.');
        }
        $person = $this->profileRepository->get($id);
        $this->imageStorage->delete($person['photo']);

        $person->update(['photo' => null]);

        $this->redirect('this');
    }


    public function handleAddPermission($userId, $permissionSlug, $multiview = false)
    {
        $this->onlyWithPermission(Model\PermissionRepository::MODIFY_USER);

        $this->permissionRepository->addPermission($userId, $permissionSlug);

        if ($userId == $this->user->id) {
            $this->flashMessage('Práva upraveny, odhlaš se, aby se to projevilo.', 'success');
        } else {
            $this->profileRepository->get($userId)->update(['logout' => true]);
        }

        if ($multiview) {
            $this->template->assignedRoles = $this->getAssignedRoles($this->template->profiles);
        }
        $this->updateViewPermissionChange();
    }

    public function handleRemovePermission($userId, $permissionSlug, $multiview = false)
    {
        $this->onlyWithPermission(Model\PermissionRepository::MODIFY_USER);


        $this->permissionRepository->removePermission($userId, $permissionSlug);

        if ($userId == $this->user->id) {
            $this->flashMessage('Práva upraveny, odhlaš se, aby se to projevilo.', 'success');
        } else {
            $this->profileRepository->get($userId)->update(['logout' => true]);
        }

        if ($multiview) {
            $this->template->assignedRoles = $this->getAssignedRoles($this->template->profiles);
        }
        $this->updateViewPermissionChange();
    }

    public function handleAddPermissionsUpToLevel($userId, $level)
    {
        $this->onlyWithPermission(Model\PermissionRepository::MODIFY_USER);

        $this->permissionRepository->addPermissionsUpToLevel($userId, $level);

        if ($userId == $this->user->id) {
            $this->flashMessage('Práva upraveny, odhlaš se, aby se to projevilo.', 'success');
        } else {
            $this->profileRepository->get($userId)->update(['logout' => true]);
        }

        $this->redirect('this');
    }

    public function handleDeleteAllPermissions($userId, $multiview = false)
    {
        $this->onlyWithPermission(Model\PermissionRepository::MODIFY_USER);

        $userPermissions = $this->permissionRepository->findByUser($userId);
        foreach ($userPermissions as $perm) {
            $this->permissionRepository->removePermission($userId, $perm);
        }

        $user = $this->profileRepository->get($userId);
        $user->update(['calendar_token' => null]);
        if ($multiview)
            $this->template->assignedRoles = $this->getAssignedRoles($this->template->profiles);

        $this->flashMessage('Všechna práva pro ' . $user . ' jsou fuč.');

    }

    public function handleApproveUser($userId)
    {
        $this->onlyWithPermission('modify-user');

        $profile = $this->profileRepository->get($userId);

        if (!$profile) throw new Nette\Application\BadRequestException();

        $profile->update(['approved_by_id' => $this->user->id]);
        $this->permissionRepository->addPermission($userId, Model\PermissionRepository::MEMBER);

        $this->flashMessage('Uživatel byl schválen, hurá.', 'success');

        $this->redirect('this');
    }

    public function handleDeleteUser($userId)
    {
        $this->onlyWithPermission(Model\PermissionRepository::MODIFY_USER);

        $this->profileRepository->get($userId)->delete();

        $this->flashMessage('Smazán a už ho nikdy neuvidíme.', 'success');

        $this->redirect('this');
    }

    public function updateViewPermissionChange()
    {
        if ($this->isAjax()) {
            $this->redrawControl('permissions');
            $this->redrawControl('flashes');
        } else {
            $this->redirect('this');
        }
    }


    public function getAssignedRoles($profiles)
    {
        $assignedRoles = [];
        foreach ($profiles as $profile) {
            $assignedRoles[$profile->id] = $this->permissionRepository->findByUser($profile->id);
        }
        return $assignedRoles;
    }
}