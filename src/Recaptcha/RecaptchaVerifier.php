<?php

namespace Beelab\Recaptcha2Bundle\Recaptcha;

use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RecaptchaVerifier
{
    // The default input drawn by Google JS
    private const GOOGLE_DEFAULT_INPUT = 'g-recaptcha-response';

    /**
     * @var ReCaptcha
     */
    private $reCaptcha;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var bool
     */
    private $enabled;

    public function __construct(ReCaptcha $reCaptcha, RequestStack $requestStack, bool $enabled = true)
    {
        $this->reCaptcha = $reCaptcha;
        $this->requestStack = $requestStack;
        $this->enabled = $enabled;
    }

    public function verify(?string $recaptchaValue = null): void
    {
        if (!$this->enabled) {
            return;
        }

        $request = $this->getRequest();
        // We don't override the value provided by the form
        // If empty, we use the default input drawn by google JS we need to get
        // the value with hardcoded variable
        if (
            (null === $recaptchaValue || empty($recaptchaValue)) &&
            $request->request->has(self::GOOGLE_DEFAULT_INPUT)
        ) {
            $recaptchaValue = $request->request->get(self::GOOGLE_DEFAULT_INPUT);
        }

        $response = $this->reCaptcha->verify($recaptchaValue, $request->getClientIp());
        if (!$response->isSuccess()) {
            throw new RecaptchaException($response);
        }
    }

    private function getRequest(): Request
    {
        if (\is_callable([$this->requestStack, 'mainRequest'])) {
            $request = $this->requestStack->getMainRequest();   // symfony 5.3+
        } else {
            $request = $this->requestStack->getMasterRequest();
        }
        if (null === $request) {
            throw new \UnexpectedValueException('Cannot find request.');
        }

        return $request;
    }
}
