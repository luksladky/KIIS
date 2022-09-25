<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 31. 7. 2016
 * Time: 17:37
 */

namespace App\Presenters;

//use App\Forms\PasswordRecoveryFormFactory;
use Nette;
use App\Forms\SignFormFactory;
use App\Forms\RegisterFormFactory;
use App\Forms\PasswordRecoveryFormFactory;
use App\Forms\ChangePasswordFormFactory;
use App\Model\UserManager;

class SignPresenter extends BasePresenter
{

    /** @persistent */
    public $backlink = '';

    /** @var UserManager @inject */
    public $userManager;

    public function renderDefault() {
        $this->user->logout();
    }

    public function actionOut()
    {
        $this->user->logout(true);
        $this->flashMessage('Sbohem, příteli!', 'success');
        $this->redirect('Homepage:default');
    }

    public function actionConfirmRegistration($token)
    {
        $confirmed = $this->userManager->confirmRegistration($token);
        if ($confirmed) {
            $this->user->logout(true);
            $this->flashMessage('Email je potvrzený. Zkontroluj schránku, jestli už jsme tě stihli schválit. Nebo se prostě zkus přihlásit.');
            $this->redirect('Sign:');
        } else {
            $this->flashMessage('Ověření emailu selhalo, budeš se muset registrovat znovu :-(', 'danger');
            $this->redirect('Sign:up');
        }
        $this->redirect('Homepage:default');
    }

    public function actionResetPassword($login, $token)
    {
        $token_match = $this->userManager->validateResetPasswordToken($login, $token);
        $this->template->token_match = $token_match;
        if (!$token_match) {
            $this->flashMessage('Tenhle odkaz nám nefunguje. Zkus si nechat poslat jiný', 'danger');
            $this->redirect('Sign:passwordRecovery');
        }
        $this['changePasswordForm']->setDefaults(['reset_token' => $token]);
    }
    
    
    /**** COMPONENTS *********/
    
    
    public function createComponentSignInForm()
    {
        $form = (new SignFormFactory($this->user))->create();
        $form->onSuccess[] = function (Nette\Application\UI\Form $form) {
            if (!$this->user->identity->confirmed)
                $this->sendConfirmationEmail($this->user->identity->name,
                    $this->user->identity->email,
                    $this->userManager->getRegistrationToken($this->user->id));

            $form->getPresenter()->restoreRequest($this->backlink);
            $form->getPresenter()->redirect('Homepage:');
        };
        return $form;
    }

    public function createComponentRegisterForm()
    {
        $form = (new RegisterFormFactory())->create();
        $form->onSuccess[] = array($this, 'registerFormSubmitted');
        return $form;
    }


    public function registerFormSubmitted($form, $values)
    {
        $email = $values->email;
        $password = $values->password;
        $name = $values->name;
        $nickname = Nette\Utils\Strings::length($values->nickname) > 0 ? $values->nickname : $name;
        try {
            $token = $this->userManager->add($email, $password, $nickname, $name);

            $this->sendConfirmationEmail($name, $email, $token);
            $this->flashMessage('Super! Počkej, až tvoji registraci někdo schválí. Na mail ti přijde upozornění.','success');
            $this->flashMessage('Na email jsme ti poslali odkaz na ověření mailové adresy. Zatím na něj prosím klikni.');
            $this->redirect('Homepage:default');
        } catch (\App\Model\DuplicateNameException $e) {
            $this->flashMessage('Tohle jméno už někdo používá.');

        }
    }


    protected function createComponentPasswordRecoveryForm()
    {
        $form = (new PasswordRecoveryFormFactory())->create();
        $form->onSuccess[] = array($this, 'passwordRecoveryFormSubmitted');
        return $form;
    }

    public function passwordRecoveryFormSubmitted($form, $values)
    {
        $email = $values['email'];
        $token = $this->userManager->generateResetPasswordToken($email);
        $this->sendPasswordRecoveryEmail($email, $token);
        $this->flashMessage('Klikni prosím na odkaz, který jsme ti poslali na email.');
    }

    public function createComponentChangePasswordForm()
    {
        $form = (new ChangePasswordFormFactory(false))->create();
        $form->onSuccess[] = array($this, 'changePasswordFormSucceeded');
        return $form;
    }

    public function changePasswordFormSucceeded($form, $values)
    {
        if ($this->userManager->resetPassword($values['reset_token'], $values['password'])) {
            $this->flashMessage('Heslo změněno, zkus se přihlásit.', 'success');
            $this->redirect('Sign:');
        } else {
            $this->flashMessage('Klíč v odkazu nebyl správný, zkus si nechat poslat jiný.', 'danger');
            $this->redirect('Sign:passwordRecovery');
        }
    }
    

    /********************* HELPERS ******************/

    /**Send confirmation email with token (key)
     * @param $name
     * @param $email
     * @param $token
     */
    public function sendConfirmationEmail($name, $email, $token)
    {
        $template = $this->createTemplate();
        $template->setFile(__DIR__ . '/../templates/Sign/confirmation-email.latte');
        $template->token = $token;
        $template->name = $name;

        $this->sendMail($email, "Potvrzení účtu - KIIS.", $template);
    }


    /**Send password recovery token to given email
     * @param $email
     * @param $token
     */
    public function sendPasswordRecoveryEmail($email, $token)
    {
        $template = $this->createTemplate();
        $template->setFile(__DIR__ . '/../templates/Sign/password-recovery-email.latte');
        $template->token = $token;
        $template->email_encoded = Nette\Utils\Strings::webalize($email);

        $this->sendMail($email, 'Obnovení hesla - KIIS', $template);
    }



}