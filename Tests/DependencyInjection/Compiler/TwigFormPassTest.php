<?php

namespace Beelab\Recaptcha2Bundle\Tests\DependencyInjection\Compiler;

use Beelab\Recaptcha2Bundle\DependencyInjection\Compiler\TwigFormPass;
use PHPUnit\Framework\TestCase;

class TwigFormPassTest extends TestCase
{
    public function testProcessWithouParameter()
    {
        $builder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()->getMock();

        $builder->expects($this->once())->method('hasParameter')->will($this->returnValue(false));

        $pass = new TwigFormPass();
        $pass->process($builder);
    }

    public function testProcess()
    {
        $builder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()->getMock();

        $builder->expects($this->once())->method('hasParameter')->will($this->returnValue(true));
        $builder->expects($this->once())->method('setParameter');
        $builder->expects($this->once())->method('getParameter')->will($this->returnValue([]));

        $pass = new TwigFormPass();
        $pass->process($builder);
    }
}
