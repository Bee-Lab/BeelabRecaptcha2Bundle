<?php

namespace Beelab\Recaptcha2Bundle\Tests;

use Beelab\Recaptcha2Bundle\BeelabRecaptcha2Bundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class BeelabRecaptcha2BundleTest extends TestCase
{
    public function testBuild(): void
    {
        /** @var ContainerBuilder&\PHPUnit\Framework\MockObject\MockObject $builder */
        $builder = $this->createMock(ContainerBuilder::class);

        $bundle = new BeelabRecaptcha2Bundle();
        $bundle->build($builder);
        $this->assertInstanceOf(BeelabRecaptcha2Bundle::class, $bundle);
    }
}
