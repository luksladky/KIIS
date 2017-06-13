<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 18. 5. 2017
 * Time: 17:44
 */

namespace App\Components;

use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Neon\Exception;

trait TMailer
{
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

        try{
            $mailer->send($mail);
        } catch (Exception $e) {
            dump($e);
        }
    }

}