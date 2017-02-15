<?php

namespace Beelab\Recaptcha2Bundle\Tests\DependencyInjection;

use Beelab\Recaptcha2Bundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class ConfigurationTest extends TestCase
{
    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $this->assertInstanceOf(
            'Symfony\Component\Config\Definition\Builder\TreeBuilder',
            $configuration->getConfigTreeBuilder()
        );
    }
}
