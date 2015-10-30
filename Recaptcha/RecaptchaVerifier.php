<?php

namespace Beelab\Recaptcha2Bundle\Recaptcha;

use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\Request;

/**
 * RecaptchaVerifier.
 */
class RecaptchaVerifier
{
    /**
     * @var ReCaptcha
     */
    private $reCaptcha;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var bool
     */
    private $enabled = true;

    /**
     * @param ReCaptcha $reCaptcha
     * @param Request   $request
     * @param bool      $enabled
     */
    public function __construct(ReCaptcha $reCaptcha, Request $request, $enabled = true)
    {
        $this->reCaptcha = $reCaptcha;
        $this->request = $request;
        $this->enabled = $enabled;
    }

    /**
     * Verify reCaptcha response.
     */
    public function verify()
    {
        if ($this->enabled) {
            $recaptchaValue = $this->request->request->get('g-recaptcha-response');
            /* @var \ReCaptcha\Response $response */
            $response = $this->reCaptcha->verify($recaptchaValue, $this->request->getClientIp());
            if (!$response->isSuccess()) {
                throw new RecaptchaException($response);
            }
        }
    }
}
