<?php

namespace Beelab\Recaptcha2Bundle\Recaptcha;

use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RecaptchaVerifier
{
    // The default input drawn by Google JS
    private const GOOGLE_DEFAULT_INPUT = 'g-recaptcha-response';

    public function __construct(
        private readonly ReCaptcha $reCaptcha,
        private readonly RequestStack $requestStack,
        private readonly bool $enabled = true,
    ) {
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
        if (empty($recaptchaValue) && $request->request->has(self::GOOGLE_DEFAULT_INPUT)) {
            try {
                $recaptchaValue = $request->request->get(self::GOOGLE_DEFAULT_INPUT);
            } catch (BadRequestException) {
                throw new RecaptchaException(new Response(false));
            }
        }

        if (!is_string($recaptchaValue)) {
            throw new RecaptchaException(new Response(false));
        }

        $response = $this->reCaptcha->verify($recaptchaValue, $request->getClientIp());
        if (!$response->isSuccess()) {
            throw new RecaptchaException($response);
        }
    }

    private function getRequest(): Request
    {
        if (null === $request = $this->requestStack->getMainRequest()) {
            throw new \UnexpectedValueException('Cannot find request.');
        }

        return $request;
    }
}
