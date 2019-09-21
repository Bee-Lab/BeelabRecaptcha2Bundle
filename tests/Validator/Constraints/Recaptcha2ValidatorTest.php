<?php

namespace Beelab\Recaptcha2Bundle\Tests\Validator\Constraints;

use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaException;
use Beelab\Recaptcha2Bundle\Recaptcha\RecaptchaVerifier;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2Validator;
use PHPUnit\Framework\TestCase;
use ReCaptcha\Response;
use Symfony\Component\Validator\Context\ExecutionContext;

final class Recaptcha2ValidatorTest extends TestCase
{
    /** @var ExecutionContext|\PHPUnit\Framework\MockObject\MockObject */
    protected $context;

    /** @var RecaptchaVerifier|\PHPUnit\Framework\MockObject\MockObject */
    protected $verifier;

    /** @var Recaptcha2Validator */
    protected $validator;

    protected function setUp(): void
    {
        $this->context = $this->createMock(ExecutionContext::class);
        $this->verifier = $this->createMock(RecaptchaVerifier::class);
        $this->validator = new Recaptcha2Validator($this->verifier);
        $this->validator->initialize($this->context);
    }

    public function testValidateShouldThrowException(): void
    {
        /** @var Response&\PHPUnit\Framework\MockObject\MockObject $response */
        $response = $this->createMock(Response::class);
        $response->expects($this->once())->method('getErrorCodes')->willReturn([]);
        $exception = new RecaptchaException($response);
        $constraint = new Recaptcha2();
        $this->verifier->expects($this->once())->method('verify')->will($this->throwException($exception));
        $this->context->expects($this->once())->method('addViolation');

        $this->validator->validate('dummy', $constraint);
    }

    public function testValidateShouldNotThrowException(): void
    {
        $constraint = new Recaptcha2();
        $this->verifier->expects($this->once())->method('verify');
        $this->context->expects($this->never())->method('addViolation');

        $this->validator->validate('dummy', $constraint);
    }

    public function testValidateShouldAcceptEmptyValues(): void
    {
        $constraint = new Recaptcha2();
        $this->verifier->expects($this->once())->method('verify');
        $this->context->expects($this->never())->method('addViolation');

        $this->validator->validate(null, $constraint);
    }
}
