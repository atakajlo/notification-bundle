<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification\Notifier;

use Atakajlo\Notifications\Notifier\NotifierInterface;

class NotifierRegistry implements NotifierRegistryInterface
{
    private array $notifiers = [];

    public function __construct(iterable $notifiers)
    {
        foreach ($notifiers as $key => $notifier) {
            $this->notifiers[$key] = $notifier;
        }
    }

    public function get(string $key): NotifierInterface
    {
        if (false === \array_key_exists($key, $this->notifiers)) {
            throw new \RuntimeException('There is no notifier with key "%s"', $key);
        }

        return $this->notifiers[$key];
    }

    public function getNotifiers(): array
    {
        return $this->notifiers;
    }
}