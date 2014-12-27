<?php

namespace Innmind\ProvisionerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('innmind_provisioner');

        $rootNode
            ->children()
                ->arrayNode('threshold')
                    ->children()
                        ->arrayNode('cpu')
                            ->children()
                                ->integerNode('max')
                                    ->defaultValue(100)
                                    ->min(0)
                                ->end()
                                ->integerNode('min')
                                    ->defaultValue(0)
                                    ->min(0)
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('load_average')
                            ->children()
                                ->floatNode('max')
                                    ->min(0)
                                ->end()
                                ->floatNode('min')
                                    ->min(0)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('triggers')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('alerting')
                    ->children()
                        ->scalarNode('email')->end()
                        ->arrayNode('webhook')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('rabbitmq')
                    ->children()
                        ->arrayNode('queue_depth')
                            ->children()
                                ->integerNode('history_length')
                                    ->min(1)
                                    ->defaultValue(10)
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}