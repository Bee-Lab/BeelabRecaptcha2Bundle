<?php

namespace Beelab\Recaptcha2Bundle\Recaptcha;

use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\RequestStack;

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
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var bool
     */
    private $enabled = true;

    /**
     * @param ReCaptcha    $reCaptcha
     * @param RequestStack $requestStack
     * @param bool         $enabled
     */
    public function __construct(ReCaptcha $reCaptcha, RequestStack $requestStack, $enabled = true)
    {
        $this->reCaptcha = $reCaptcha;
        $this->request = $requestStack->getCurrentRequest();
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
