<?php

namespace Beelab\Recaptcha2Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TwigFormPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('twig.form.resources')) {
            return;
        }
        $container->setParameter('twig.form.resources', array_merge(
            array('BeelabRecaptcha2Bundle:form:fields.html.twig'),
            $container->getParameter('twig.form.resources')
        ));
    }
}