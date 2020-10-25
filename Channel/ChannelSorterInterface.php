<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Channel;

interface ChannelSorterInterface
{
    /**
     * @param ChannelDescriptor[] $channels
     * @return ChannelDescriptor[]
     */
    public function sort(iterable $channels): iterable;
}