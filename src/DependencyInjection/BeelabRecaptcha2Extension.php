<?php

namespace Beelab\Recaptcha2Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use ReCaptcha\RequestMethod\CurlPost;
use ReCaptcha\RequestMethod\Post;

final class BeelabRecaptcha2Extension extends Extension
{
    /**
     * @param array<string, mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('beelab_recaptcha2.site_key', $config['site_key']);
        $container->setParameter('beelab_recaptcha2.secret', $config['secret']);
        $container->setParameter('beelab_recaptcha2.enabled', $config['enabled']);

        $requestMethodClass = $this->getRequestMethod($config['request_method']);
        $container->setParameter('beelab_recaptcha2.request_method', $requestMethodClass);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.xml');
    }

    private function getRequestMethod(string $requestMethod): string
    {
        return match ($requestMethod) {
            'curl_post' => CurlPost::class,
            default => Post::class,
        };
    }
}
