<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 1. 8. 2016
 * Time: 13:07
 */

namespace App\Forms;

use Nette\Application\UI\Form;

use \Vodacek\Forms\Controls\DateInput;

class AddEventFormFactory extends FormFactory
{


    public function create()
    {


        $form = new Form();

        $form->addText('title', 'Název události')
            ->setRequired('Jak se to bude jmenovat?');

        $form->addTextArea('description', 'Popis události')
            ->setAttribute('id','mceEditor')
            ->setAttribute('class', 'mceEditor');

        $form->addText('location','Místo')
            ->setRequired('Kde to bude?');

        $dateFromInput = new DateInput('Začátek', DateInput::TYPE_DATETIME);
        $dateFromInput->setRequired('Kdy to začíná?');
        $form->addComponent($dateFromInput, 'date_from');

        //->addRule(Form::FILLED);
        $dateToInput = new DateInput('Konec', DateInput::TYPE_DATETIME);
        $dateToInput->addRule(Form::FILLED, 'Kdy to končí?');
        $form->addComponent($dateToInput, 'date_to');

        $form->addText('roles', 'Role na akci')
            ->setAttribute('class', 'rolesInput');

        $form->addMultiUpload('upload')->setAttribute('class','hidden');

        $form->addSubmit('send', 'Vytvořit akci');

        $form->addHidden('event_id');

        $form->getElementPrototype()->onsubmit('tinyMCE.triggerSave()');
        
        $this->addBootstrapClasses($form);
        return $form;

    }

}