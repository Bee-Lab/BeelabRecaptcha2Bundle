<?php

namespace Beelab\Recaptcha2Bundle\Tests\DependencyInjection\Compiler;

use Beelab\Recaptcha2Bundle\DependencyInjection\Compiler\TwigFormPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class TwigFormPassTest extends TestCase
{
    public function testProcessWithoutFilesystem(): void
    {
        /** @var ContainerBuilder&\PHPUnit\Framework\MockObject\MockObject $builder */
        $builder = $this->createMock(ContainerBuilder::class);

        $builder->method('hasDefinition')->willReturn(false);

        $pass = new TwigFormPass();
        $pass->process($builder);
    }

    public function testProcessWithoutFilesystemAndWithNativeFilesystem(): void
    {
        /** @var ContainerBuilder&\PHPUnit\Framework\MockObject\MockObject $builder */
        $builder = $this->createMock(ContainerBuilder::class);
        $definition = $this->createMock(Definition::class);

        $builder->expects($this->at(0))->method('hasDefinition')->willReturn(false);
        $builder->expects($this->at(1))->method('hasDefinition')->willReturn(true);
        $builder->expects($this->once())->method('getDefinition')->willReturn($definition);
        $builder->expects($this->once())->method('hasParameter')->willReturn(false);
        $definition->method('addMethodCall');

        $pass = new TwigFormPass();
        $pass->process($builder);
    }

    public function testProcessWithoutParameter(): void
    {
        /** @var ContainerBuilder&\PHPUnit\Framework\MockObject\MockObject $builder */
        $builder = $this->createMock(ContainerBuilder::class);
        $definition = $this->createMock(Definition::class);

        $builder->expects($this->once())->method('hasDefinition')->willReturn(true);
        $builder->expects($this->once())->method('getDefinition')->willReturn($definition);
        $builder->expects($this->once())->method('hasParameter')->willReturn(false);
        $definition->method('addMethodCall');

        $pass = new TwigFormPass();
        $pass->process($builder);
    }

    public function testProcess(): void
    {
        /** @var ContainerBuilder&\PHPUnit\Framework\MockObject\MockObject $builder */
        $builder = $this->createMock(ContainerBuilder::class);
        $definition = $this->createMock(Definition::class);

        $builder->expects($this->once())->method('hasDefinition')->willReturn(true);
        $builder->expects($this->once())->method('getDefinition')->willReturn($definition);
        $builder->expects($this->once())->method('hasParameter')->willReturn(true);
        $builder->expects($this->once())->method('setParameter');
        $builder->expects($this->once())->method('getParameter')->willReturn([]);
        $definition->method('addMethodCall');

        $pass = new TwigFormPass();
        $pass->process($builder);
    }
}
