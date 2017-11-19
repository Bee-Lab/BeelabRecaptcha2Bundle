<?php

namespace Beelab\Recaptcha2Bundle\Tests\Validator\Constraints;

use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException;
use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2Validator;
use PHPUnit\Framework\TestCase;
use ReCaptcha\Response;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\ExecutionContext as LegacyContext;

class Recaptcha2ValidatorTest extends TestCase
{
    protected $context;
    protected $verifier;
    protected $validator;

    protected function setUp()
    {
        $class = class_exists(ExecutionContext::class) ? ExecutionContext::class : LegacyContext::class;
        $this->context = $this->createMock($class, [], [], '', false);
        $this->verifier = $this->getMockBuilder(RecaptchaVerifier::class)->disableOriginalConstructor()->getMock();
        $this->validator = new Recaptcha2Validator($this->verifier);
        $this->validator->initialize($this->context);
    }

    public function testValidateShouldThrowException()
    {
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->expects($this->once())->method('getErrorCodes')->will($this->returnValue([]));
        $exception = new RecaptchaException($response);
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

    public function testValidateShouldAcceptEmptyValues()
    {
        $constraint = new Recaptcha2();
        $this->verifier->expects($this->once())->method('verify');
        $this->context->expects($this->never())->method('addViolation');

        $this->validator->validate(null, $constraint);
    }
}
