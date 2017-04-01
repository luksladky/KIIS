<?php
namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/**Form for sending password recovery emails to given address.
 * Class PasswordRecoveryFormFactory
 * @package App\Forms
 */
class PasswordRecoveryFormFactory extends FormFactory
{
    public function create()
    {
        $form = new Form;

        $form->addText('email', 'Tvůj email')
            ->addRule(Form::EMAIL)
            ->addRule(Form::FILLED);

        $form->addSubmit('send', 'Pošli mi odkaz');

        $this->addBootstrapClasses($form);

        return $form;
    }
}