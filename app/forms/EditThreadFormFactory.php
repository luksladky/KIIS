<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 9. 8. 2016
 * Time: 17:35
 */

namespace App\Forms;

use Nette\Application\UI\Form;

class EditThreadFormFactory extends FormFactory
{
    public function create() {
        $form = new Form();

        $form->addTextArea('title','Téma')
            ->setAttribute('id','mceEditor')
            ->setAttribute('class','mceEditor');

        $form->addHidden('event_id');
        $form->addHidden('thread_id');


        $form->addText('restrict_users','Skrýt pro uživatele')
            ->setAttribute('class','usersInput');

        $form->addSubmit('send','Uložit změny');

        $this->addBootstrapClasses($form);

        return $form;
    }

}