<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\DependencyInjection;

use Atakajlo\NotificationBundle\Notification\NotificationDescriptor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AtakajloNotificationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $notificationDescriptor = [];
        foreach ($config['notifications'] as $name => $notificationConfig) {
            $notificationDescriptor[$name] = $notificationConfig['channels'];
        }

        $notificationDescriptorDefinition = $container->getDefinition(NotificationDescriptor::class);
        $notificationDescriptorDefinition->replaceArgument(0, $notificationDescriptor);

//        $container->getDefinition('asd')->addTag()
    }
}