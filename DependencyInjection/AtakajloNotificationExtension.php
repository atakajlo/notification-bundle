<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\DependencyInjection;

use Atakajlo\NotificationBundle\Channel\ChannelDescriptor;
use Atakajlo\NotificationBundle\Notification\NotificationDescriptor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AtakajloNotificationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['notifications'] as $notificationName => $notificationConfig) {
            $notifications[$notificationName] = $notificationConfig['channels'];
            $definition = new Definition(
                NotificationDescriptor::class,
                [
                    $notificationName,
                    $notificationConfig['channels'],
                ]
            );

            $definition->addTag('notification.notification.descriptor');

            $container->setDefinition(
                sprintf('atakajlo.notification.notification.%s.descriptor', $notificationName),
                $definition
            );
        }

        foreach ($config['channels'] as $channelName => $channelArguments) {
            $definition = new Definition(
                ChannelDescriptor::class,
                [
                    $channelName,
                    $channelArguments['stop_after_notify'],
                    $channelArguments['priority'],
                ]
            );
            $definition->addTag('notification.channel.descriptor');

            $container->setDefinition(
                sprintf('atakajlo.notification.channel.%s.descriptor', $channelName),
                $definition
            );
        }
    }
}