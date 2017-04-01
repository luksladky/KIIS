<?php
namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

class EditUserFormFactory extends FormFactory
{
    /**
     * @return Form
     */
    public function create()
    {
        $form = new Form;

        $form->addHidden('id')
            ->setRequired();

        $form->addUpload('photo', "Nahrát novou fotku")
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE, "JPEG, GIF nebo PNG formát.")
            ->addRule(Form::MAX_FILE_SIZE, "Je to moc velký, dej mi menší než dvě mega.", 2 * 1024 * 1024);

        $form->addHidden('deletePhoto');

        $form->addText('name', 'Celé jméno')
            ->setRequired();
        $form->addText('nickname','Přezdívka');

        $form->addText('phone','Telefon');

        $form->addText('city','Město');

        $form->addSubmit('send', 'Uložit')
            ->setAttribute('class', 'btn btn-primary');

        $this->addBootstrapClasses($form);


        return $form;
    }
}