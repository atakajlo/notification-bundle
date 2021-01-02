<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Channel;

class ChannelDescriptor
{
    private string $name;
    private int $priority;
    private bool $stopAfterNotify;

    public function __construct(string $name, int $priority, bool $stopAfterNotify)
    {
        $this->name = $name;
        $this->priority = $priority;
        $this->stopAfterNotify = $stopAfterNotify;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function shouldStopAfterNotify(): bool
    {
        return $this->stopAfterNotify;
    }
}