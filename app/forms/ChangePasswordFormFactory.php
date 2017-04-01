<?php
namespace App\Forms;

use App\FrontModule\Forms\CaptchaForm;
use Nette,
    Nette\Application\UI\Form;
use Minetro\Forms\reCAPTCHA\ReCaptchaField;
use Minetro\Forms\reCAPTCHA\ReCaptchaHolder;
use Minetro\Forms\reCAPTCHA\IReCaptchaValidatorFactory;


class ChangePasswordFormFactory extends FormFactory
{
    /**If signed by facebook, password is not set.
     * @var bool
     */
    private $userHaveOld;

    public function __construct($userHaveOld)
    {
        $this->userHaveOld = $userHaveOld;
    }


    /**
     * @return Form
     */
    public function create()
    {


        $form = new Form;

        if ($this->userHaveOld) {
            $form->addPassword('oldPassword', 'Aktuální heslo:')
                ->setRequired();
        }


        $form->addPassword('password', 'Nové heslo: *', 20)
            ->setOption('description', 'Alespoň 6 znaků.')
            ->setRequired('Nové heslo prosím.')
            ->addRule(Form::MIN_LENGTH, 'Minimal length is %d chars.', 6);

        $form->addPassword('password2', 'Nové heslo podruhé: *', 20)
            ->addConditionOn($form['password'], Form::FILLED)
            ->setRequired('A ještě jednou pro ověření.')
            ->addRule(Form::EQUAL, 'Passwords doesn\'t match.', $form['password']);

        $form->addHidden('reset_token');

        if ($this->userHaveOld) {
            $form->addSubmit('send', 'Změnit heslo');
        } else {
            $form->addSubmit('send', 'Nastavit heslo');
        }

        $this->addBootstrapClasses($form);

        return $form;
    }
}