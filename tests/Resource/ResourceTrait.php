<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource;

use Depositphotos\SDK\Http\HttpClient;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

trait ResourceTrait
{
    /**
     * @param array $requestData
     * @param array|ResponseInterface $responseData
     *
     * @return \Depositphotos\SDK\Http\HttpClient
     */
    protected function createHttpClient(array $requestData, $responseData): HttpClient
    {
        if (is_array($responseData)) {
            $response = $this->createMock(ResponseInterface::class);
            $response->method('getBody')->willReturn(Utils::streamFor(json_encode($responseData)));
        } elseif ($responseData instanceof ResponseInterface) {
            $response = $responseData;
        } else {
            $response = null;
        }

        if (!$response instanceof ResponseInterface) {
            throw new \InvalidArgumentException('Invalid response');
        }

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->with($this->callback(function (RequestInterface $request) use ($requestData) {
            $this->assertEquals((string) $request->getBody(), http_build_query($requestData));
           return true;
        }))->willReturn($response);

        return new HttpClient($client);
    }
}
