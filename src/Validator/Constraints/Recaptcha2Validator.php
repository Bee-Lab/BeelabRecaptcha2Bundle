<?php

namespace Beelab\Recaptcha2Bundle\Validator\Constraints;

use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException;
use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class Recaptcha2Validator extends ConstraintValidator
{
    /**
     * @var RecaptchaVerifier
     */
    private $verifier;

    public function __construct(RecaptchaVerifier $verifier)
    {
        $this->verifier = $verifier;
    }

    public function validate($value, Constraint $constraint): void
    {
        try {
            $this->verifier->verify($value, $constraint->android);
        } catch (RecaptchaException $e) {
            /* @var Recaptcha2 $constraint */
            $this->context->addViolation($constraint->message);
        }
    }
}
