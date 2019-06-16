<?php

namespace Beelab\Recaptcha2Bundle\Tests\Recaptcha;

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
        $this->recaptcha = $this->getMockBuilder(ReCaptcha::class)->disableOriginalConstructor()->getMock();
        $this->request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $this->stack = $this->createMock(RequestStack::class);
        $this->stack->expects($this->once())->method('getMasterRequest')->willReturn($this->request);
    }

    public function testVerifyDisabled(): void
    {
        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack, false);
        $verifier->verify('captcha-response');
    }

    public function testVerifySuccess(): void
    {
        $this->request->expects($this->once())->method('getClientIp')->willReturn('127.0.0.1');
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->expects($this->once())->method('isSuccess')->willReturn(true);
        $this->recaptcha->expects($this->once())->method('verify')->willReturn($response);

        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack);
        $verifier->verify('captcha-response');
    }

    public function testVerifyFailure(): void
    {
        $this->expectException(\Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException::class);

        $this->request->expects($this->once())->method('getClientIp')->willReturn('127.0.0.1');
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->expects($this->once())->method('isSuccess')->willReturn(false);
        $response->expects($this->once())->method('getErrorCodes')->willReturn([]);
        $this->recaptcha->expects($this->once())->method('verify')->willReturn($response);

        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack);
        $verifier->verify('captcha-response');
    }
}
