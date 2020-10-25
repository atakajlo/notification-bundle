<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Channel;

class ChannelRegistry implements ChannelRegistryInterface
{
    private array $channels = [];

    /**
     * @param ChannelDescriptor[] $channels
     */
    public function __construct(iterable $channels)
    {
        foreach ($channels as $channel) {
            $this->channels[$channel->getName()] = $channel;
        }
    }

    public function get(string $name): ChannelDescriptor
    {
        if (false === isset($this->channels[$name])) {
            throw new \RuntimeException(sprintf('Channel "%s" not found in configuration', $name));
        }

        return $this->channels[$name];
    }
}