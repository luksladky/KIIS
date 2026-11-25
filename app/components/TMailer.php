<?php
/**
 * Created by PhpStorm.
 * User: Lukas
 * Date: 18. 5. 2017
 * Time: 17:44
 */

namespace App\Components;

trait TMailer
{
    /** @var \App\Components\MailSender @inject */
    public $mailSender;

    /**Shorthand for sending emails.
     * @param $email
     * @param $subject
     * @param $template
     */
    public function sendMail($email, $subject, $template)
    {
        $this->mailSender->send($email, $subject, $template);
    }

}
