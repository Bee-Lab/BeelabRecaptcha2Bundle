<?php

namespace Beelab\Recaptcha2Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('beelab_recaptcha2');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->enumNode('request_method')
                    ->values(['curl_post', 'post', 'http_client'])
                    ->defaultValue('post')
                ->end()
                ->scalarNode('site_key')
                    ->isRequired()
                ->end()
                ->scalarNode('secret')
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
