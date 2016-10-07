<?php

namespace Beelab\Recaptcha2Bundle\Tests\DependencyInjection;

use Beelab\Recaptcha2Bundle\DependencyInjection\BeelabRecaptcha2Extension;

/**
 * @group unit
 */
class BeelabRecaptcha2ExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadSetParameters()
    {
        $container = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()->getMock();
        $parameterBag = $this->getMockBuilder('Symfony\Component\DependencyInjection\ParameterBag\ParameterBag')
            ->disableOriginalConstructor()->getMock();

        $parameterBag->expects($this->any())->method('add');
        $container->expects($this->any())->method('getParameterBag')->will($this->returnValue($parameterBag));

        $extension = new BeelabRecaptcha2Extension();
        $configs = [
            ['request_method' => 'curl_post'],
            ['site_key' => 'foo'],
            ['secret' => 'bar'],
            ['enabled' => true],
        ];
        $extension->load($configs, $container);
    }
}
