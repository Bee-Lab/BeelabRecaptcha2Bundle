<?php

namespace Beelab\Recaptcha2Bundle\Validator\Constraints;

use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException;
use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class Recaptcha2Validator extends ConstraintValidator
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
            $this->verifier->verify($value);
        } catch (RecaptchaException $e) {
            $this->context->addViolation($constraint->message);
        }
    }
}
