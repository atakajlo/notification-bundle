<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification;

class NotificationDescriptor
{
    private string $name;
    private array $channels;

    public function __construct(string $name, array $channels)
    {
        $this->name = $name;
        $this->channels = $channels;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getChannels(): array
    {
        return $this->channels;
    }
}