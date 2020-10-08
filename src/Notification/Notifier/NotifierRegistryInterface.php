<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification\Notifier;

use Atakajlo\Notifications\Notifier\NotifierInterface;

interface NotifierRegistryInterface
{
    public function get(string $key): NotifierInterface;

    public function getNotifiers(): array;
}