<?php

namespace Beelab\Recaptcha2Bundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class Recaptcha2 extends Constraint
{
    public const INVALID_RECAPTCHA_ERROR = 'b2c483cd-90b6-4810-aa45-fd615e89f046';

    protected const ERROR_NAMES = [
        self::INVALID_RECAPTCHA_ERROR => 'INVALID_RECAPTCHA_ERROR',
    ];

    public string $message = 'Invalid ReCaptcha.';

    public function validatedBy(): string
    {
        return 'recaptcha2';
    }
}
