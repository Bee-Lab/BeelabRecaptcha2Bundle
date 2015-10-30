<?php

namespace Beelab\Recaptcha2Bundle\Tests;

use Beelab\Recaptcha2Bundle\BeelabRecaptcha2Bundle;

class BeelabRecaptcha2BundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $builder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()->getMock();

        $bundle = new BeelabRecaptcha2Bundle();
        $bundle->build($builder);
    }
}
