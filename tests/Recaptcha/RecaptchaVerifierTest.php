<?php

namespace Beelab\Recaptcha2Bundle\Tests\Recaptcha;

use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException;
use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;
use PHPUnit\Framework\TestCase;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class RecaptchaVerifierTest extends TestCase
{
    protected $recaptcha;

    protected $request;

    protected $stack;

    protected function setUp(): void
    {
        $this->recaptcha = $this->createMock(ReCaptcha::class);
        $this->request = $this->createMock(Request::class);
        $this->stack = $this->createMock(RequestStack::class);
    }

    public function testVerifyDisabled(): void
    {
        $this->stack->expects(self::never())->method('getMasterRequest');
        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack, false);
        $verifier->verify('captcha-response');
    }

    public function testVerifySuccess(): void
    {
        if (\is_callable([$this->stack, 'getMainRequest'])) {
            $this->stack->expects(self::once())->method('getMainRequest')->willReturn($this->request);
        } else {
            $this->stack->expects(self::once())->method('getMasterRequest')->willReturn($this->request);
        }
        $this->request->expects(self::once())->method('getClientIp')->willReturn('127.0.0.1');
        $response = $this->createMock(Response::class);
        $response->expects(self::once())->method('isSuccess')->willReturn(true);
        $this->recaptcha->expects(self::once())->method('verify')->willReturn($response);

        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack);
        $verifier->verify('captcha-response');
    }

    public function testVerifyFailure(): void
    {
        $this->expectException(RecaptchaException::class);

        if (\is_callable([$this->stack, 'getMainRequest'])) {
            $this->stack->expects(self::once())->method('getMainRequest')->willReturn($this->request);
        } else {
            $this->stack->expects(self::once())->method('getMasterRequest')->willReturn($this->request);
        }
        $this->request->expects(self::once())->method('getClientIp')->willReturn('127.0.0.1');
        $response = $this->createMock(Response::class);
        $response->expects(self::once())->method('isSuccess')->willReturn(false);
        $response->expects(self::once())->method('getErrorCodes')->willReturn([]);
        $this->recaptcha->expects(self::once())->method('verify')->willReturn($response);

        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack);
        $verifier->verify('captcha-response');
    }
}
