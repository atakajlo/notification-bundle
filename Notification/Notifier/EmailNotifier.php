<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification\Notifier;

use Atakajlo\Notifications\Notifier\NotifierException;
use Atakajlo\Notifications\Notifier\NotifierInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class EmailNotifier implements NotifierInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify(string $recipient, string $subject, string $body): void
    {
        try {
            $this->mailer->send($recipient, $subject, $body);
        } catch (TransportExceptionInterface $e) {
            throw new NotifierException($e->getMessage());
        }
    }
}