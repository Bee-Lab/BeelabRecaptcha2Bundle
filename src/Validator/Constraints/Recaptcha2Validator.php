<?php

namespace Beelab\Recaptcha2Bundle\Validator\Constraints;

use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException;
use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class Recaptcha2Validator extends ConstraintValidator
{
    public function __construct(private readonly RecaptchaVerifier $verifier)
    {
    }

    /**
     * @param string|null $value
     * @param Recaptcha2  $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        try {
            $this->verifier->verify($value);
        } catch (RecaptchaException) {
            $this->context->addViolation($constraint->message);
        }
    }
}
