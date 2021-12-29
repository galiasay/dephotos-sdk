<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource;

use GuzzleHttp\Utils;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use GuzzleHttp\Psr7\Request as HttpRequest;

class Resource
{
    /** @var ClientInterface */
    private $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    protected function send(RequestInterface $request): HttpResponseInterface
    {
        $httpRequest = $this->convertToHttpRequest($request);

        return $this->httpClient->sendRequest($httpRequest);
    }

    protected function convertHttpResponseToArray(HttpResponseInterface $httpResponse): array
    {
        return (array) Utils::jsonDecode((string) $httpResponse->getBody(), true);
    }

    private function convertToHttpRequest(RequestInterface $request): HttpRequestInterface
    {
        return new HttpRequest('POST', '', $this->getHeaders(), $this->prepareBody($request));
    }

    private function prepareBody(RequestInterface $request): string
    {
        return (string) json_encode($request->toArray());
    }

    private function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }
}
