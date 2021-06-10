<?php

namespace Beelab\Recaptcha2Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('beelab_recaptcha2');
        // BC layer for symfony/config < 4.2
        $rootNode = \method_exists($treeBuilder, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root('beelab_recaptcha2');
        $rootNode
            ->children()
                ->enumNode('request_method')
                    ->values(['curl_post', 'post'])
                    ->defaultValue('post')
                ->end()
                ->scalarNode('site_key')
                    ->isRequired()
                ->end()
                ->scalarNode('secret')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('android_site_key')
                    ->isRequired()
                ->end()
                ->scalarNode('android_secret')
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('enabled')
                    ->defaultTrue()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
