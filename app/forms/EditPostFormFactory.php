<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 1. 4. 2017
 * Time: 10:59
 */

namespace App\Forms;

use Nette\Application\UI\Form;
class EditPostFormFactory extends FormFactory
{

    public function create()
    {
        $form = new Form();

        $form->addTextArea('content')
            ->setAttribute('class','mceEditor')
            ->setAttribute('id','mceEditor');
        
        $form->addHidden('post_id');
        $form->addHidden('thread_id');
        
        $form->addSubmit('send', 'Uložit úpravu');
        
        $this->addBootstrapClasses($form);

        return $form;
    }
}