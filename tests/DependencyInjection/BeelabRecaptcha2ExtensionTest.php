<?php

namespace Beelab\Recaptcha2Bundle\Tests\DependencyInjection;

use Beelab\Recaptcha2Bundle\DependencyInjection\BeelabRecaptcha2Extension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * @group unit
 */
final class BeelabRecaptcha2ExtensionTest extends TestCase
{
    public function testLoadSetParameters(): void
    {
        /** @var ContainerBuilder|\PHPUnit\Framework\MockObject\MockObject $container */
        $container = $this->createMock(ContainerBuilder::class);
        /** @var ParameterBag|\PHPUnit\Framework\MockObject\MockObject $parameterBag */
        $parameterBag = $this->createMock(ParameterBag::class);

        $parameterBag->method('add');
        $container->method('getParameterBag')->willReturn($parameterBag);

        $extension = new BeelabRecaptcha2Extension();
        $configs = [
            'one' => ['request_method' => 'curl_post'],
            'two' => ['site_key' => 'foo'],
            'three' => ['secret' => 'bar'],
            'four' => ['enabled' => true],
        ];
        $extension->load($configs, $container);
        self::assertInstanceOf(BeelabRecaptcha2Extension::class, $extension);
    }

    public function testLoadSetParametersPost(): void
    {
        /** @var ContainerBuilder|\PHPUnit\Framework\MockObject\MockObject $container */
        $container = $this->createMock(ContainerBuilder::class);
        /** @var ParameterBag|\PHPUnit\Framework\MockObject\MockObject $parameterBag */
        $parameterBag = $this->createMock(ParameterBag::class);

        $parameterBag->method('add');
        $container->method('getParameterBag')->willReturn($parameterBag);

        $extension = new BeelabRecaptcha2Extension();
        $configs = [
            'one' => ['request_method' => 'post'],
            'two' => ['site_key' => 'foo'],
            'three' => ['secret' => 'bar'],
            'four' => ['enabled' => true],
        ];
        $extension->load($configs, $container);
        self::assertInstanceOf(BeelabRecaptcha2Extension::class, $extension);
    }
}
