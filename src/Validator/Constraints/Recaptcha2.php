<?php

namespace Beelab\Recaptcha2Bundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class Recaptcha2 extends Constraint
{
    public $message = 'Invalid ReCaptcha.';

    public function validatedBy(): string
    {
        return 'recaptcha2';
    }
}
