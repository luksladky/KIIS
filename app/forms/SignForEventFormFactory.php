<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 12. 8. 2016
 * Time: 22:10
 */

namespace App\Forms;

use Nette\Application\UI\Form;
use \Vodacek\Forms\Controls\DateInput;

class SignForEventFormFactory extends FormFactory
{
    public function create()
    {
        $form = new Form();

        $form->addHidden('event_id');

        $form->addSelect('role', 'Funkce')
            ->setAttribute('class', 'select-first-null')
            ->addRule(Form::FILLED, 'Co budeš dělat na akci? Nevybral sis funkci.');

        $form->addCheckbox('select_date', 'Přijedu / odjedu jindy')
            ->addCondition(Form::EQUAL, true)
            ->toggle('dateInput-from')
            ->toggle('dateInput-to');

        $dateFromInput = new DateInput('Příjezd', DateInput::TYPE_DATETIME);
        $dateFromInput->setOption('id', 'dateInput-from');
        $form->addComponent($dateFromInput, 'date_from');

        //->addRule(Form::FILLED);
        $dateToInput = new DateInput('Odjezd', DateInput::TYPE_DATETIME);
        $dateToInput->setOption('id', 'dateInput-to');
        $form->addComponent($dateToInput, 'date_to');

        $form->addText('note', 'Poznámka')
            ->setRequired(false)
            ->addRule(Form::MAX_LENGTH, 'Maximálně 250 znaků', 250);

        $this->addBootstrapClasses($form);

        $form->addSubmit('send', 'Hlásím se!')
            ->setAttribute('class', 'btn btn-success btn-block');
        $form->addSubmit('sendMaybe', 'Nevím to jistě')
            ->setAttribute('class', 'btn btn-default btn-block');

        return $form;
    }
}