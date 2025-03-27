<?php

namespace Beelab\Recaptcha2Bundle\Tests\Recaptcha;

use Beelab\Recaptcha2Bundle\Recaptcha\SymfonyClientRequestMethod;
use PHPUnit\Framework\TestCase;
use ReCaptcha\RequestParameters;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SymfonyClientRequestMethodTest extends TestCase
{
    /** @var \PHPUnit\Framework\MockObject\MockObject|HttpClientInterface */
    protected $client;

    protected function setUp(): void
    {
        $this->client = $this->createMock(HttpClientInterface::class);
    }

    public function testServiceNotInjected(): void
    {
        $method = new SymfonyClientRequestMethod();
        $this->expectException(\UnexpectedValueException::class);

        $method->submit(new RequestParameters('', ''));
    }

    public function testRequestFailure(): void
    {
        $method = new SymfonyClientRequestMethod();
        $method->setClient($this->client);
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getStatusCode')->willReturn(404);
        $this->client->expects($this->once())->method('request')->willReturn($response);
        $content = $method->submit(new RequestParameters('', ''));
        self::assertEquals('{"success": false, "error-codes": ["connection-failed"]}', $content);
    }

    public function testRequestSuccess(): void
    {
        $method = new SymfonyClientRequestMethod();
        $method->setClient($this->client);
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getStatusCode')->willReturn(200);
        $response->expects($this->once())->method('getContent')->willReturn('"OK"');
        $this->client->expects($this->once())->method('request')->willReturn($response);
        $content = $method->submit(new RequestParameters('', ''));
        self::assertEquals('"OK"', $content);
    }
}
