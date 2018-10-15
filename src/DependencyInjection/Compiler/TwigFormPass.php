<?php

namespace Beelab\Recaptcha2Bundle\DependencyInjection\Compiler;

use Beelab\Recaptcha2Bundle\BeelabRecaptcha2Bundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class TwigFormPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $loaderDefinition = null;
        if ($container->hasDefinition('twig.loader.filesystem')) {
            $loaderDefinition = $container->getDefinition('twig.loader.filesystem');
        }
        if (null === $loaderDefinition && $container->hasDefinition('twig.loader.native_filesystem')) {
            $loaderDefinition = $container->getDefinition('twig.loader.native_filesystem');
        }
        if (null === $loaderDefinition) {
            return;
        }

        if (!$container->hasParameter('twig.form.resources')) {
            return;
        }

        $refl = new \ReflectionClass(BeelabRecaptcha2Bundle::class);
        $path = \dirname($refl->getFileName()).'/../templates';
        $loaderDefinition->addMethodCall('addPath', [$path]);

        $container->setParameter('twig.form.resources', \array_merge(
            ['form_fields.html.twig'],
            $container->getParameter('twig.form.resources')
        ));
    }
}
