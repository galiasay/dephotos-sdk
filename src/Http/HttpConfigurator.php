<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Http;

use Depositphotos\SDK\Http\Middleware\RequestBodyFieldsMiddleware;
use Psr\Http\Client\ClientInterface;
use GuzzleHttp\Client as GuzzleHttpClient;

class HttpConfigurator
{
    /** @var string */
    private $apiKey;

    /** @var string */
    private $endpoint;

    /** @var ClientInterface|null */
    private $httpClient;

    public function __construct(string $apiKey, string $endpoint, ?ClientInterface $httpClient = null)
    {
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
        $this->httpClient = $httpClient;
    }

    public function makeConfiguredHttpClient(): HttpClient
    {
        $configuredHttpClient = new HttpClient($this->httpClient ?? new GuzzleHttpClient([
            'base_uri' => $this->endpoint
        ]));

        $configuredHttpClient->addMiddleware(new RequestBodyFieldsMiddleware([
            'dp_apikey' => $this->apiKey,
        ]));

        return $configuredHttpClient;
    }
}
