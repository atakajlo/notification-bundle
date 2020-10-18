<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification;

use Atakajlo\NotificationBundle\Channel\ChannelRegistryInterface;
use Atakajlo\NotificationBundle\Notification\Notifier\NotifierRegistryInterface;
use Atakajlo\Notifications\Notification\NotificationInterface;
use Atakajlo\Notifications\NotificationManagerInterface;
use Atakajlo\Notifications\Notifier\NotifierException;
use Atakajlo\Notifications\Notifier\NotifierInterface;
use Atakajlo\Notifications\Recipient\RecipientInterface;
use Atakajlo\Notifications\Renderer\RendererInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class NotificationManager implements NotificationManagerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private NotifierRegistryInterface $notifierRegistry;
    private RendererInterface $renderer;
    private ChannelRegistryInterface $channelRegistry;
    private NotificationRegistryInterface $notificationRegistry;

    public function __construct(
        NotifierRegistryInterface $notifierRegistry,
        RendererInterface $renderer,
        ChannelRegistryInterface $channelRegistry,
        NotificationRegistryInterface $notificationRegistry
    ) {
        $this->notifierRegistry = $notifierRegistry;
        $this->renderer = $renderer;
        $this->channelRegistry = $channelRegistry;
        $this->notificationRegistry = $notificationRegistry;
    }

    public function notify(RecipientInterface $recipient, NotificationInterface $notification): void
    {
        $renderedNotification = $this->renderer->render($notification);

        foreach ($this->getNotifiersForNotification($notification) as $channel => $notifier) {
            try {
                $notifier->notify($recipient->getTo(), $notification->getSubject(), $renderedNotification);
            } catch (NotifierException $e) {
                $this->logger->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            }

            $channelDescriptor = $this->channelRegistry->get($channel);
            if ($channelDescriptor->shouldStopAfterNotify()) {
                return;
            }
        }
    }

    /**
     * @return NotifierInterface[]
     */
    private function getNotifiersForNotification(NotificationInterface $notification): iterable
    {
        $notificationKey = get_class($notification);
        $channels = $this->notificationRegistry->get($notificationKey)->getChannels();

        foreach ($channels as $channel) {
            yield $channel => $this->notifierRegistry->get($channel);
        }
    }
}