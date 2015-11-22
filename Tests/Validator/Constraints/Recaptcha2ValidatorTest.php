<?php

namespace Beelab\Recaptcha2Bundle\Tests\Validator\Constraints;

use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2Validator;

class Recaptcha2ValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $verifier;
    protected $validator;

    protected function setUp()
    {
        $this->context = $this->getMock(
            class_exists('Symfony\Component\Validator\Context\ExecutionContext') ? 'Symfony\Component\Validator\Context\ExecutionContext' : 'Symfony\Component\Validator\ExecutionContext',
            array(),
            array(),
            '',
            false
        );
        $this->verifier = $this->getMockBuilder('Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier')
            ->disableOriginalConstructor()->getMock();
        $this->validator = new Recaptcha2Validator($this->verifier);
        $this->validator->initialize($this->context);
    }

    public function testValidateShouldThrowException()
    {
        $response = $this->getMockBuilder('ReCaptcha\Response')->disableOriginalConstructor()->getMock();
        $response->expects($this->once())->method('getErrorCodes')->will($this->returnValue(array()));
        $exception = new \Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException($response);
        $constraint = new Recaptcha2();
        $this->verifier->expects($this->once())->method('verify')->will($this->throwException($exception));
        $this->context->expects($this->once())->method('addViolation');

        $this->validator->validate('dummy', $constraint);
    }

    public function testValidateShouldNotThrowException()
    {
        $constraint = new Recaptcha2();
        $this->verifier->expects($this->once())->method('verify');
        $this->context->expects($this->never())->method('addViolation');

        $this->validator->validate('dummy', $constraint);
    }
}
