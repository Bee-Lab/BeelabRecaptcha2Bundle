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

    public function __construct(
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null,
        ?string $message = null,
    ) {
        if (null !== $message) {
            $this->message = $message;
        }
        if (\is_array($options)) {
            trigger_deprecation('beelab/recaptcha2-bundle', '2.13', 'Passing options as an array is deprecated. Pass options as named arguments instead.');
            $options['message'] = $this->message;
        }
        parent::__construct($options, $groups, $payload);
    }

    public function validatedBy(): string
    {
        return 'recaptcha2';
    }
}
