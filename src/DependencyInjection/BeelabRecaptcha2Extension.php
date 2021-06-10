<?php

namespace Beelab\Recaptcha2Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class BeelabRecaptcha2Extension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('beelab_recaptcha2.site_key', $config['site_key']);
        $container->setParameter('beelab_recaptcha2.secret', $config['secret']);
        $container->setParameter('beelab_recaptcha2.android_site_key', $config['android_site_key']);
        $container->setParameter('beelab_recaptcha2.android_secret', $config['android_secret']);
        $container->setParameter('beelab_recaptcha2.enabled', $config['enabled']);

        $requestMethodClass = $this->getRequestMethod($config['request_method']);
        $container->setParameter('beelab_recaptcha2.request_method', $requestMethodClass);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.xml');
    }

    private function getRequestMethod($requestMethod): string
    {
        switch ($requestMethod) {
            case 'curl_post':
                return 'ReCaptcha\RequestMethod\CurlPost';
            case 'post':
            default:
                return 'ReCaptcha\RequestMethod\Post';
        }
    }
}
