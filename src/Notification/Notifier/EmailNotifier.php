<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification\Notifier;

use Atakajlo\Notifications\Notifier\NotifierInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;

class EmailNotifier implements NotifierInterface
{
    private Mailer $mailer;

    public function __construct(Mailer $mailer)
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