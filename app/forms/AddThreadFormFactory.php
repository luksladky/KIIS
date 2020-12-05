<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 9. 8. 2016
 * Time: 17:35
 */

namespace App\Forms;

use Nette\Application\UI\Form;
class AddThreadFormFactory extends FormFactory
{
    public function create() {
        $form = new Form();

        $form->addTextArea('title','Téma')
            ->setAttribute('id','mceEditor')
            ->setAttribute('class','mceEditor');

        $form->addHidden('event_id');


        $form->addText('restrict_users','Skrýt pro uživatele')
            ->setAttribute('class','usersInput');

        $form->addMultiUpload('upload');

        $form->addSubmit('send','Přidat téma');

        $form->getElementPrototype()->onsubmit('tinyMCE.triggerSave()');

        $this->addBootstrapClasses($form);

        return $form;
    }

}