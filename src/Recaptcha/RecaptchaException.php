<?php

namespace Beelab\Recaptcha2Bundle\Recaptcha;

use ReCaptcha\Response;

final class RecaptchaException extends \Exception
{
    public function __construct(Response $response)
    {
        parent::__construct('ReCaptcha errors: '.\implode(', ', $response->getErrorCodes()));
    }
}
