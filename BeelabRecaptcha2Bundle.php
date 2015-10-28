<?php

namespace Beelab\Recaptcha2Bundle;

use Beelab\Recaptcha2Bundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BeelabRecaptcha2Bundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new TwigFormPass());
    }
}
