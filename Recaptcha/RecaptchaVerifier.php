<?php

namespace Beelab\Recaptcha2Bundle\Recaptcha;

use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * RecaptchaVerifier.
 */
class RecaptchaVerifier
{
    // The default input drawed by Google JS
    const GOOGLE_DEFAULT_INPUT = 'g-recaptcha-response';

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
    public function __construct(ReCaptcha $reCaptcha, RequestStack $requestStack, bool $enabled = true)
    {
        $this->reCaptcha = $reCaptcha;
        $this->request = $requestStack->getMasterRequest();
        $this->enabled = $enabled;
    }

    /**
     * Verify reCaptcha response.
     *
     * @param string $recaptchaValue
     *
     * @throws RecaptchaException
     */
    public function verify(string $recaptchaValue)
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
            /* @var \ReCaptcha\Response $response */
            $response = $this->reCaptcha->verify($recaptchaValue, $this->request->getClientIp());
            if (!$response->isSuccess()) {
                throw new RecaptchaException($response);
            }
        }
    }
}
