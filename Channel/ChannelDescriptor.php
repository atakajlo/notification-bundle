<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Channel;

class ChannelDescriptor
{
    private string $name;
    private bool $stopAfterNotify;

    public function __construct(string $name, bool $stopAfterNotify)
    {
        $this->name = $name;
        $this->stopAfterNotify = $stopAfterNotify;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function shouldStopAfterNotify(): bool
    {
        return $this->stopAfterNotify;
    }
}