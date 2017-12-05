<?php

namespace Beelab\Recaptcha2Bundle\Tests\DependencyInjection\Compiler;

use Beelab\Recaptcha2Bundle\DependencyInjection\Compiler\TwigFormPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class TwigFormPassTest extends TestCase
{
    public function testProcessWithoutFilesystem()
    {
        $builder = $this->getMockBuilder(ContainerBuilder::class)->disableOriginalConstructor()->getMock();

        $builder->expects($this->once())->method('hasDefinition')->will($this->returnValue(false));

        $pass = new TwigFormPass();
        $pass->process($builder);
    }

    public function testProcessWithoutParameter()
    {
        $builder = $this->getMockBuilder(ContainerBuilder::class)->disableOriginalConstructor()->getMock();
        $definition = $this->createMock(Definition::class);

        $builder->expects($this->once())->method('hasDefinition')->will($this->returnValue(true));
        $builder->expects($this->once())->method('getDefinition')->will($this->returnValue($definition));
        $builder->expects($this->once())->method('hasParameter')->will($this->returnValue(false));
        $definition->expects($this->any())->method('addMethodCall');

        $pass = new TwigFormPass();
        $pass->process($builder);
    }

    public function testProcess()
    {
        $builder = $this->getMockBuilder(ContainerBuilder::class)->disableOriginalConstructor()->getMock();
        $definition = $this->createMock(Definition::class);

        $builder->expects($this->once())->method('hasDefinition')->will($this->returnValue(true));
        $builder->expects($this->once())->method('getDefinition')->will($this->returnValue($definition));
        $builder->expects($this->once())->method('hasParameter')->will($this->returnValue(true));
        $builder->expects($this->once())->method('setParameter');
        $builder->expects($this->once())->method('getParameter')->will($this->returnValue([]));
        $definition->expects($this->any())->method('addMethodCall');

        $pass = new TwigFormPass();
        $pass->process($builder);
    }
}
