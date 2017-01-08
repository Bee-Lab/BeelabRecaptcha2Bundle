<?php

namespace Beelab\Recaptcha2Bundle\Tests\Validator\Constraints;

use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use PHPUnit_Framework_TestCase as TestCase;

class Recaptcha2Test extends TestCase
{
    public function testValidatedBy()
    {
        $validator = new Recaptcha2();
        $this->assertEquals('recaptcha2', $validator->validatedBy());
    }
}
