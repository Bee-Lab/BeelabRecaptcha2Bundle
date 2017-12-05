<?php

namespace Beelab\Recaptcha2Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigFormPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $loaderDefinition = null;
        if ($container->hasDefinition('twig.loader.filesystem')) {
            $loaderDefinition = $container->getDefinition('twig.loader.filesystem');
        }
        if (null === $loaderDefinition) {
            return;
        }
        if (!$container->hasParameter('twig.form.resources')) {
            return;
        }

        $refl = new \ReflectionClass('Beelab\Recaptcha2Bundle\BeelabRecaptcha2Bundle');
        $path = dirname($refl->getFileName()).'/../templates';
        $loaderDefinition->addMethodCall('addPath', [$path]);

        $container->setParameter('twig.form.resources', array_merge(
            ['form_fields.html.twig'],
            $container->getParameter('twig.form.resources')
        ));
    }
}
