<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Channel;

interface ChannelRegistryInterface
{
    public function get(string $name): ChannelDescriptor;
}