<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification;

use Atakajlo\NotificationBundle\Notification\Notifier\NotifierRegistryInterface;
use Atakajlo\Notifications\Notification\NotificationInterface;
use Atakajlo\Notifications\NotificationManagerInterface;
use Atakajlo\Notifications\Notifier\NotifierInterface;
use Atakajlo\Notifications\Recipient\RecipientInterface;
use Atakajlo\Notifications\Renderer\RendererInterface;

class NotificationManager implements NotificationManagerInterface
{
    private NotifierRegistryInterface $notifierRegistry;
    private NotificationDescriptor $notificationDescriptor;
    private RendererInterface $renderer;

    public function __construct(
        NotifierRegistryInterface $notifierRegistry,
        NotificationDescriptor $notificationDescriptor,
        RendererInterface $renderer
    ) {
        $this->notifierRegistry = $notifierRegistry;
        $this->notificationDescriptor = $notificationDescriptor;
        $this->renderer = $renderer;
    }

    public function notify(RecipientInterface $recipient, NotificationInterface $notification): void
    {
        $renderedNotification = $this->renderer->render($notification);

        foreach ($this->getNotifiersForNotification($notification) as $notifier) {
            $notifier->notify($recipient->getTo(), $notification->getSubject(), $renderedNotification);
        }
    }

    /**
     * @return NotifierInterface[]
     */
    private function getNotifiersForNotification(NotificationInterface $notification): iterable
    {
        $channels = $this->notificationDescriptor->getForNotification($notification);

        foreach ($channels as $channel) {
            yield $this->notifierRegistry->get($channel);
        }
    }
}