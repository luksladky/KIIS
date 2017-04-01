<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 10. 8. 2016
 * Time: 13:28
 */

namespace App\Forms;

use Nette\Application\UI\Form;

class AddPostFormFactory extends FormFactory
{
    public function create()
    {
        $form = new Form();

        $form->addTextArea('content')
            ->setAttribute('class','mceEditor')
            ->setAttribute('id','mceEditor');

        $form->addHidden('thread_id');
        $form->addHidden('parent');

        $form->addSubmit('send', 'Přídat komentář');

        //$form->getElementPrototype()->onsubmit('tinyMCE.triggerSave()');

        $this->addBootstrapClasses($form);

        return $form;
    }
}