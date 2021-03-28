<?php

namespace Beelab\Recaptcha2Bundle\Tests\Validator\Constraints;

use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use PHPUnit\Framework\TestCase;

final class Recaptcha2Test extends TestCase
{
    public function testValidatedBy(): void
    {
        $validator = new Recaptcha2();
        self::assertEquals('recaptcha2', $validator->validatedBy());
    }
}
