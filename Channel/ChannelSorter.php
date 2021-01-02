<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Channel;

class ChannelSorter implements ChannelSorterInterface
{
    /**
     * {@inheritdoc}
     */
    public function sort(iterable $channels): iterable
    {
        $channels = [...$channels];
        usort($channels, static fn (ChannelDescriptor $a, ChannelDescriptor $b) => $a->getPriority() <=> $b->getPriority());

        return $channels;
    }
}