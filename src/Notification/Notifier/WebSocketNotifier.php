<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Notification\Notifier;

use Atakajlo\Notifications\Notifier\NotifierInterface;
use phpcent\Client;

class WebSocketNotifier implements NotifierInterface
{
    private Client $client;
    private string $channel;

    public function __construct(Client $client, string $channel)
    {
        $this->client = $client;
        $this->channel = $channel;
    }

    public function notify(string $recipient, string $subject, string $body): void
    {
        $channelName = sprintf('%s#%s', $this->channel, $recipient);

        $this->client->publish($channelName, ['message' => $body]);
    }
}