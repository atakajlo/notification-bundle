<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Tests\Stub;

use Atakajlo\Notifications\Notification\NotificationInterface;

class TestNotification implements NotificationInterface
{
    public function getSubject(): string
    {
        return 'subject';
    }

    public function getTemplate(): string
    {
        return 'template';
    }

    public function getParameters(): array
    {
        return [];
    }
}