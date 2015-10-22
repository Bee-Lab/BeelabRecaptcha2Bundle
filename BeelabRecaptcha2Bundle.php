<?php

namespace Beelab\Recaptcha2Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Beelab\Recaptcha2Bundle\DependencyInjection\Compiler\TwigFormPass;

class BeelabRecaptcha2Bundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new TwigFormPass());
    }
}
