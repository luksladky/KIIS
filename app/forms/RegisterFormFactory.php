<?php
namespace App\Forms;

use App\FrontModule\Forms\CaptchaForm;
use Nette,
    Nette\Application\UI\Form;
use Minetro\Forms\reCAPTCHA\ReCaptchaField;
use Minetro\Forms\reCAPTCHA\ReCaptchaHolder;
use Minetro\Forms\reCAPTCHA\IReCaptchaValidatorFactory;


class RegisterFormFactory extends FormFactory
{

    /**
     * @return Form
     */
    public function create()
    {


        $form = new Form;

        $form->addText('nickname','Přezdívka')
            ->setRequired('Jak ti budeme říkat?');

        $form->addText('name', 'Jméno a příjmení:')
            ->setRequired('Sděl nám prosím své ctěné jméno a taky příjmení.');

        $form->addText('email', 'Email:', 35)
            ->setRequired('Jaký je tvůj mail?')
            ->addCondition(Form::FILLED)
            ->addRule(Form::EMAIL, 'Email address is not valid');

        $form->addPassword('password', 'Heslo:', 20)
            ->setOption('description', 'Alespoň 6 znaků')
            ->setRequired('Heslo prosím.')
            ->addRule(Form::MIN_LENGTH, 'Minimul length is %d chars.', 6);

        $form->addPassword('password2', 'Heslo ještě jednou:', 20)
            ->addConditionOn($form['password'], Form::FILLED)
            ->setRequired('A heslo pro potvrzení.')
            ->addRule(Form::EQUAL, 'Hesla nesouhlasí.', $form['password']);

        //$form->addReCaptcha();

        $form->addSubmit('send', 'Registerovat');

        $this->addBootstrapClasses($form);

        return $form;
    }
}