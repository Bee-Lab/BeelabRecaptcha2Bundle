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
        $verifier->verify();
    }

    public function testVerifySuccess()
    {
        $bag = $this->getMockBuilder('Symfony\Component\HttpFoundation\ParameterBag')
            ->disableOriginalConstructor()->getMock();
        $bag->expects($this->once())->method('get')->will($this->returnValue('foo'));
        $this->request->request = $bag;
        $response = $this->getMockBuilder('ReCaptcha\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())->method('isSuccess')->will($this->returnValue(true));
        $this->recaptcha->expects($this->once())->method('verify')->will($this->returnValue($response));

        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack);
        $verifier->verify();
    }

    /**
     * @expectedException \Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException
     */
    public function testVerifyFailure()
    {
        $bag = $this->getMockBuilder('Symfony\Component\HttpFoundation\ParameterBag')
            ->disableOriginalConstructor()->getMock();
        $bag->expects($this->once())->method('get')->will($this->returnValue('foo'));
        $this->request->request = $bag;
        $response = $this->getMockBuilder('ReCaptcha\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())->method('isSuccess')->will($this->returnValue(false));
        $response->expects($this->once())->method('getErrorCodes')->will($this->returnValue(array()));
        $this->recaptcha->expects($this->once())->method('verify')->will($this->returnValue($response));

        $verifier = new RecaptchaVerifier($this->recaptcha, $this->stack);
        $verifier->verify();
    }
}
