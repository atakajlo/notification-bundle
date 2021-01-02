<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification;

class NotificationRegistry implements NotificationRegistryInterface
{
    private array $notifications = [];

    /**
     * @param NotificationDescriptor[] $notifications
     */
    public function __construct(iterable $notifications)
    {
        foreach ($notifications as $notification) {
            $this->notifications[$notification->getName()] = $notification;
        }
    }

    public function get(string $name): NotificationDescriptor
    {
        if (false === isset($this->notifications[$name])) {
            throw new \RuntimeException(sprintf('Notification "%s" not found in configuration', $name));
        }

        return $this->notifications[$name];
    }
}