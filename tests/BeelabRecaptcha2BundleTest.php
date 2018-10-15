<?php

namespace Beelab\Recaptcha2Bundle\Tests;

use Beelab\Recaptcha2Bundle\BeelabRecaptcha2Bundle;
use PHPUnit\Framework\TestCase;

final class BeelabRecaptcha2BundleTest extends TestCase
{
    public function testBuild(): void
    {
        $builder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()->getMock();

        $bundle = new BeelabRecaptcha2Bundle();
        $bundle->build($builder);
        $this->assertInstanceOf(BeelabRecaptcha2Bundle::class, $bundle);
    }
}
