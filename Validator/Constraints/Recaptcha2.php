<?php

namespace Beelab\Recaptcha2Bundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Recaptcha2 extends Constraint
{
    public $message = 'Invalid ReCaptcha.';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'recaptcha2';
    }
}
