<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 26. 1. 2017
 * Time: 18:22
 */

namespace App\Forms;

use Nette\Application\UI\Form;

use \Vodacek\Forms\Controls\DateInput;

class EditHomepageFormFactory extends FormFactory
{

    public function create()
    {
        $form = new Form();

        $form->addTextArea('content', 'Obsah hlavní stránky')
            ->setAttribute('id','mceEditorHomepage');

        $form->addSubmit('send', 'Uložit úpravy');


        $this->addBootstrapClasses($form);
        return $form;
    }

}