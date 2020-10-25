<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification;

use Atakajlo\NotificationBundle\Channel\ChannelDescriptor;
use Atakajlo\NotificationBundle\Channel\ChannelRegistryInterface;
use Atakajlo\NotificationBundle\Channel\ChannelSorterInterface;
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
    private ChannelSorterInterface $channelSorter;

    public function __construct(
        NotifierRegistryInterface $notifierRegistry,
        RendererInterface $renderer,
        ChannelRegistryInterface $channelRegistry,
        NotificationRegistryInterface $notificationRegistry,
        ChannelSorterInterface $channelSorter
    ) {
        $this->notifierRegistry = $notifierRegistry;
        $this->renderer = $renderer;
        $this->channelRegistry = $channelRegistry;
        $this->notificationRegistry = $notificationRegistry;
        $this->channelSorter = $channelSorter;
    }

    public function notify(RecipientInterface $recipient, NotificationInterface $notification): void
    {
        $renderedNotification = $this->renderer->render($notification);

        /** @var ChannelDescriptor $channelDescriptor */
        /** @var NotifierInterface $notifier */
        foreach ($this->getNotifiersForNotification($notification) as [$channelDescriptor, $notifier]) {
            try {
                $notifier->notify($recipient->getTo(), $notification->getSubject(), $renderedNotification);
            } catch (NotifierException $e) {
                $this->logger->error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            }

            if ($channelDescriptor->shouldStopAfterNotify()) {
                return;
            }
        }
    }

    private function getNotifiersForNotification(NotificationInterface $notification): iterable
    {
        $notificationKey = get_class($notification);
        $channelDescriptors = $this->channelSorter->sort(
            array_map(
                fn(string $channel) => $this->channelRegistry->get($channel),
                $this->notificationRegistry->get($notificationKey)->getChannels()
            )
        );

        foreach ($channelDescriptors as $channelDescriptor) {
            yield [$channelDescriptor, $this->notifierRegistry->get($channelDescriptor->getName())];
        }
    }
}