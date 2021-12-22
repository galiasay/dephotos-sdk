<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface as HttpRequestInterface;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;
use GuzzleHttp\Psr7\Request as HttpRequest;
use GuzzleHttp\Utils;

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
        $response = $this->httpClient->sendRequest($httpRequest);

        return $response;
    }

    /**
     * @return mixed[]
     */
    protected function convertHttpResponseToArray(HttpResponseInterface $httpResponse): array
    {
        return (array) Utils::jsonDecode((string) $httpResponse->getBody());
    }

    private function convertToHttpRequest(RequestInterface $request): HttpRequestInterface
    {
        return new HttpRequest('POST', '', $this->getHeaders(), $this->prepareBody($request));
    }

    private function prepareBody(RequestInterface $request): string
    {
        return Utils::jsonEncode($request->toArray());
    }

    /**
     * @return string[]
     */
    private function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }
}