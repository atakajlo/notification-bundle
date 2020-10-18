<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification;

interface NotificationRegistryInterface
{
    public function get(string $name): NotificationDescriptor;
}