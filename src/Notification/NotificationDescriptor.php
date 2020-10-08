<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification;

use Atakajlo\Notifications\Notification\NotificationInterface;

class NotificationDescriptor
{
    private iterable $notifications;

    public function __construct(iterable $notifications)
    {
        foreach ($notifications as $notification => $channels) {
            $this->notifications[$notification] = $channels;
        }
    }

    public function getForNotification(NotificationInterface $notification): array
    {
        $notificationKey = get_class($notification);
        if (false !== array_key_exists($notificationKey, $this->notifications)) {
            return $this->notifications[$notificationKey];
        }

        return [];
    }

    public function getNotifications(): iterable
    {
        return $this->notifications;
    }
}