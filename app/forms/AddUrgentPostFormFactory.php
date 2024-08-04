<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 10. 8. 2016
 * Time: 13:28
 */

namespace App\Forms;

use Nette\Application\UI\Form;
use App\Components\TMailer;

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

        $form->addMultiUpload('upload');

        $form->addSubmit('send', 'Přídat zprávu');

        $form->onSuccess[] = [$this, 'sendEmail'];

        //$form->getElementPrototype()->onsubmit('tinyMCE.triggerSave()');

        $this->addBootstrapClasses($form);

        return $form;
    }
    
    public function sendEmail(Form $form, $values) {
        $template = $this->createTemplate();
        $template->setFile(__DIR__ . '/../templates/Email/urgentEmail.latte');
        $template->zprava = $form->content;


        $this['TMailer']->sendMail('vojtech@zmatlovi.cz', 'Test',$template);
    }
}