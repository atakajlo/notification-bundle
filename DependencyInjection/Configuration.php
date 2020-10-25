<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('atakajlo_notification');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('channels')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->booleanNode('stop_after_notify')
                                ->defaultFalse()
                            ->end()
                            ->scalarNode('priority')
                                ->defaultValue(0)
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('notifications')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->arrayNode('channels')
                                ->beforeNormalization()->castToArray()->end()
                                ->scalarPrototype()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;


        return $treeBuilder;
    }
}