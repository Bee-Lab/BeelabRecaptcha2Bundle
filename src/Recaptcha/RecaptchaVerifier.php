<?php

namespace Beelab\Recaptcha2Bundle\Recaptcha;

use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\RequestStack;

class RecaptchaVerifier
{
    // The default input drawed by Google JS
    const GOOGLE_DEFAULT_INPUT = 'g-recaptcha-response';

    /**
     * @var ReCaptcha
     */
    private $reCaptcha;

    /**
     * @var ReCaptcha
     */
    private $androidReCaptcha;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var bool
     */
    private $enabled;

    public function __construct(ReCaptcha $reCaptcha, ReCaptcha $androidReCaptcha, RequestStack $requestStack, bool $enabled = true)
    {
        $this->reCaptcha = $reCaptcha;
        $this->androidReCaptcha = $androidReCaptcha;
        $this->request = $requestStack->getMasterRequest();
        $this->enabled = $enabled;
    }

    public function verify(?string $recaptchaValue = null, bool $android): void
    {
        // We don't override the value provided by the form
        // If empty, we use the default input drawn by google JS we need to get
        // the value with hardcoded variable
        if (
            (null === $recaptchaValue || empty($recaptchaValue)) &&
            $this->request->request->has(self::GOOGLE_DEFAULT_INPUT)
        ) {
            $recaptchaValue = $this->request->request->get(self::GOOGLE_DEFAULT_INPUT);
        }

        if ($this->enabled) {
            $verifier = $android ? $this->androidReCaptcha : $this->reCaptcha;
            /* @var \ReCaptcha\Response $response */
            $response = $verifier->verify($recaptchaValue, $this->request->getClientIp());
            if (!$response->isSuccess()) {
                throw new RecaptchaException($response);
            }
        }
    }
}
