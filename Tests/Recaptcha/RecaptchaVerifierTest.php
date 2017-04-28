<?php

namespace Beelab\Recaptcha2Bundle\Tests\Recaptcha;

use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;
use PHPUnit\Framework\TestCase;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RecaptchaVerifierTest extends TestCase
{
    protected $recaptcha;
    protected $request;
    protected $stack;

    protected function setUp()
    {
        $this->recaptcha = $this->getMockBuilder(ReCaptcha::class)->disableOriginalConstructor()->getMock();
        $this->request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $this->stack = $this->createMock(RequestStack::class);
        $this->stack->expects($this->once())->method('getCurrentRequest')->will($this->returnValue($this->request));
    }

    public function testVerifyDisabled()
    {
        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack, false);
        $verifier->verify('captcha-response');
    }

    public function testVerifySuccess()
    {
        $this->request->expects($this->once())->method('getClientIp')->will($this->returnValue('127.0.0.1'));
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->expects($this->once())->method('isSuccess')->will($this->returnValue(true));
        $this->recaptcha->expects($this->once())->method('verify')->will($this->returnValue($response));

        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack);
        $verifier->verify('captcha-response');
    }

    /**
     * @expectedException \Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException
     */
    public function testVerifyFailure()
    {
        $this->request->expects($this->once())->method('getClientIp')->will($this->returnValue('127.0.0.1'));
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->expects($this->once())->method('isSuccess')->will($this->returnValue(false));
        $response->expects($this->once())->method('getErrorCodes')->will($this->returnValue([]));
        $this->recaptcha->expects($this->once())->method('verify')->will($this->returnValue($response));

        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack);
        $verifier->verify('captcha-response');
    }
}
