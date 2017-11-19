<?php

namespace Beelab\Recaptcha2Bundle\Recaptcha;

use ReCaptcha\Response;

/**
 * RecaptchaException.
 */
class RecaptchaException extends \Exception
{
    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        parent::__construct('ReCaptcha errors: '.implode(', ', $response->getErrorCodes()));
    }
}
