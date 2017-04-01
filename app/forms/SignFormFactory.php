<?php

namespace App\Forms;

use App\Model\UserManager;
use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;


class SignFormFactory extends FormFactory
{
    /** @var User */
    private $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /** try {
     * $this->getUser()->login($values->username, $values->password);
     * $this->redirect('Homepage:');
     *
     * } catch (Nette\Security\AuthenticationException $e) {
     * $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
     * }
     * @return Form
     */
    public function create()
    {
        $form = new Form;
        $form->addText('email', 'Email nebo přezdívka:')
            ->setAttribute('placeholder', 'Email nebo předívka')
            ->setRequired('Sem patří email nebo přezdívka.');
//            ->addRule(Form::EMAIL,'Enter valid email')

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Nazapomeň na heslo!.');

        $form->addCheckbox('remember', 'Zůstat přihlášený');

        $form->addSubmit('send', 'Přihlásit se');

        $this->addBootstrapClasses($form);

        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }


    public function formSucceeded(Form $form, $values)
    {
        if ($values->remember) {
            $this->user->setExpiration('14 days', false);
        } else {
            $this->user->setExpiration('20 minutes', true);
        }

        try {
            $this->user->login($values->email, $values->password);
        } catch (Nette\Security\AuthenticationException $e) {
            //$form->addError($e->getMessage());
            if ($e->getCode() == UserManager::DUPLICIT_IDENTIFICATOR) {
                $form->addError('Stejnou přezdívku používá víc lidí. Zkus to přes email.');
            } else {
                $form->addError('Chybné přihlašovací údaje.');
            }
        }
    }

}
