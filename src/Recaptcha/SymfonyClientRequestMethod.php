<?php

namespace Beelab\Recaptcha2Bundle\Recaptcha;

use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod;
use ReCaptcha\RequestParameters;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SymfonyClientRequestMethod implements RequestMethod
{
    private ?HttpClientInterface $client = null;

    public function __construct(
        private string $siteVerifyUrl = ReCaptcha::SITE_VERIFY_URL,
    ) {
    }

    public function setClient(?HttpClientInterface $client): void
    {
        $this->client = $client;
    }

    public function submit(RequestParameters $params): string
    {
        if (null === $this->client) {
            throw new \UnexpectedValueException('Needed service is not injected.');
        }

        $response = $this->client->request('POST', $this->siteVerifyUrl, [
            'body' => $params->toQueryString(),
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        if (200 !== $response->getStatusCode()) {
            return '{"success": false, "error-codes": ["'.ReCaptcha::E_CONNECTION_FAILED.'"]}';
        }

        return $response->getContent();
    }
}
