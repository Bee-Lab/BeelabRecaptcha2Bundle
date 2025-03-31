<?php

namespace Beelab\Recaptcha2Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RequestMethodPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $service = $container->getDefinition('beelab_recaptcha2.google_recaptcha');
        $methodClass = $container->getParameter('beelab_recaptcha2.request_method');
        if ($container->hasDefinition($methodClass)) {
            $methodService = $container->getDefinition($methodClass);
        } else {
            $methodService = $container->register($methodClass, $methodClass);
            $methodService->setPublic(false);
        }
        $service->replaceArgument(1, $methodService);
    }
}
