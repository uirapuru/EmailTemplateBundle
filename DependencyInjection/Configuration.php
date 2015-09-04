<?php

namespace TPN\EmailTemplatesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
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
        $rootNode = $treeBuilder->root('tpn_email_templates');

        $rootNode
            ->children()
                ->arrayNode('email_variables')
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('email_layout')
                    ->children()
                        ->scalarNode('header')->isRequired()->end()
                        ->scalarNode('footer')->isRequired()->end()
                        ->scalarNode('styles')->isRequired()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
