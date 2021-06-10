<?php

namespace Beelab\Recaptcha2Bundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class Recaptcha2 extends Constraint
{
    public $message = 'Une erreur est survenue lors de la validation du captcha.';
    
    public $android = false;

    public function validatedBy(): string
    {
        return 'recaptcha2';
    }
}
