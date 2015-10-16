<?php

namespace Beelab\Recaptcha2Bundle\Validator\Constraints;

use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException;
use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Recaptcha2Validator.
 */
class Recaptcha2Validator extends ConstraintValidator
{
    /**
     * @var RecaptchaVerifier
     */
    private $verifier;

    /**
     * @param RecaptchaVerifier $verifier
     */
    public function __construct(RecaptchaVerifier $verifier)
    {
        $this->verifier = $verifier;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        try {
            $this->verifier->verify();
        } catch (RecaptchaException $e) {
            $this->context->addViolation($constraint->message);
        }
    }
}
