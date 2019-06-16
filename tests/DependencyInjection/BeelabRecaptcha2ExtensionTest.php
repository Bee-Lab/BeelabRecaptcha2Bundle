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
        $container = $this->getMockBuilder(ContainerBuilder::class)->disableOriginalConstructor()->getMock();
        $parameterBag = $this->getMockBuilder(ParameterBag::class)->disableOriginalConstructor()->getMock();

        $parameterBag->expects($this->any())->method('add');
        $container->expects($this->any())->method('getParameterBag')->willReturn($parameterBag);

        $extension = new BeelabRecaptcha2Extension();
        $configs = [
            ['request_method' => 'curl_post'],
            ['site_key' => 'foo'],
            ['secret' => 'bar'],
            ['enabled' => true],
        ];
        $extension->load($configs, $container);
        $this->assertInstanceOf(BeelabRecaptcha2Extension::class, $extension);
    }

    public function testLoadSetParametersPost(): void
    {
        $container = $this->getMockBuilder(ContainerBuilder::class)->disableOriginalConstructor()->getMock();
        $parameterBag = $this->getMockBuilder(ParameterBag::class)->disableOriginalConstructor()->getMock();

        $parameterBag->expects($this->any())->method('add');
        $container->expects($this->any())->method('getParameterBag')->willReturn($parameterBag);

        $extension = new BeelabRecaptcha2Extension();
        $configs = [
            ['request_method' => 'post'],
            ['site_key' => 'foo'],
            ['secret' => 'bar'],
            ['enabled' => true],
        ];
        $extension->load($configs, $container);
        $this->assertInstanceOf(BeelabRecaptcha2Extension::class, $extension);
    }
}
