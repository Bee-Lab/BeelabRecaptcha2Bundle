<?php

namespace Beelab\Recaptcha2Bundle\Tests\Recaptcha;

use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;

class RecaptchaVerifierTest extends \PHPUnit_Framework_TestCase
{
    protected $recaptcha;
    protected $request;
    protected $stack;

    protected function setUp()
    {
        $this->recaptcha = $this->getMockBuilder('ReCaptcha\ReCaptcha')->disableOriginalConstructor()->getMock();
        $this->request = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()->getMock();
        $this->stack = $this->getMock('Symfony\Component\HttpFoundation\RequestStack');
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
        $response = $this->getMockBuilder('ReCaptcha\Response')->disableOriginalConstructor()->getMock();
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
        $response = $this->getMockBuilder('ReCaptcha\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())->method('isSuccess')->will($this->returnValue(false));
        $response->expects($this->once())->method('getErrorCodes')->will($this->returnValue([]));
        $this->recaptcha->expects($this->once())->method('verify')->will($this->returnValue($response));

        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack);
        $verifier->verify('captcha-response');
    }
}
