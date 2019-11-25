<?php

namespace Beelab\Recaptcha2Bundle;

use Beelab\Recaptcha2Bundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BeelabRecaptcha2Bundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new TwigFormPass());
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
