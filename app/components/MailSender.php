<?php

namespace App\Components;

use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Mail\SendException;
use Nette\Mail\SendmailMailer;
use Tracy\Debugger;

/**
 * Sends HTML emails through the configured mailer (SMTP when `mail: smtp: true` is set in config.local.neon).
 */
class MailSender
{
    /** @var IMailer */
    private $mailer;

    /** @var string */
    private $fromEmail;

    /** @var string|null */
    private $fromName;

    public function __construct($fromEmail, $fromName, IMailer $mailer)
    {
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
        $this->mailer = $mailer;

        if ($mailer instanceof SendmailMailer && !$mailer->commandArgs) {
            // Envelope sender must match From domain so SPF aligns for DMARC.
            $mailer->commandArgs = '-f' . $fromEmail;
        }
    }

    public function send($to, $subject, $htmlBody)
    {
        $mail = new Message;
        $mail->setFrom($this->fromEmail, $this->fromName)
            ->addTo($to)
            ->setSubject($subject)
            ->setHtmlBody((string) $htmlBody);

        try {
            $this->mailer->send($mail);
        } catch (SendException $e) {
            Debugger::log($e, Debugger::EXCEPTION);
        }
    }
}
