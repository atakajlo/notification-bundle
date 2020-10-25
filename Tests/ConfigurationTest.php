<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Tests;

use Atakajlo\NotificationBundle\DependencyInjection\Configuration;
use Atakajlo\NotificationBundle\Tests\Stub\TestNotification;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testSuccess()
    {
        $processor = new Processor();

        $configs = [
            'atakajlo_notification' => [
                'channels' => [
                    'email' => [],
                    'sms' => [
                        'stop_after_notify' => true
                    ]
                ],
                'notifications' => [
                    TestNotification::class => [
                        'name' => TestNotification::class,
                        'channels' => ['sms']
                    ]
                ]
            ]
        ];

        $config = $processor->processConfiguration(new Configuration(), $configs);
        self::assertTrue(true);
    }
}