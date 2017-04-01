<?php
namespace App\Presenters;


use Nette;
use Nette\Application\UI\Form;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;

class BasePresenter extends Nette\Application\UI\Presenter
{

    use \WebChemistry\Images\TPresenter;

    
    public function beforeRender()
    {
        parent::beforeRender();
        $this->template->isHttpError = false;
        $this->template->addFilter('timeagoinwords', 'App\Model\Filters::timeAgoInWords');
        $this->template->addFilter('czechdate', function ($date, $year = true){
            $en = array("January","February","March","April","May","June","July","August","September","October","November","December");
            $cz = array("ledna","února","března","dubna","května","června","července","srpna","září","října","listopadu","prosince");
            $d = $year ? $date->format('j. F Y') : $date->format('j. F');
            $dateFormatted = str_replace($en, $cz, $d);
            return $dateFormatted;
        } );


    }

    /**Shorthand for sending emails.
     * @param $email
     * @param $subject
     * @param $template
     */
    public function sendMail($email, $subject, $template)
    {
        $mail = new Message;

        $mail->setFrom("noreply@klub.ddmtrebic.cz")
            ->addTo($email)
            ->setSubject($subject)
            ->setHtmlBody($template);

        $mailer = new SendmailMailer();
        $mailer->send($mail);
    }

}