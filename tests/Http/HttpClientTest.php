<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Http;

use Depositphotos\SDK\Http\HttpClient;
use Depositphotos\SDK\Http\MiddlewareInterface;
use Depositphotos\SDK\Tests\BaseTestCase;
use GuzzleHttp\Psr7;
use GuzzleHttp\Utils;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class HttpClientTest extends BaseTestCase
{
    public function testSendRequest(): void
    {
        $request = $this->createRequest();
        $expectedResponse = $this->createResponse($request->getBody());

        $httpClient = $this->createHttpClient($request, $expectedResponse);
        $response = $httpClient->sendRequest($request);

        $this->assertEquals($expectedResponse, $response);
    }

    public function testSendRequestWithMiddleware(): void
    {
        $data = [
            'dp_apikey' => 'apikey',
            'dp_command' => 'command'
        ];

        $request = $this->createRequest();
        $expectedRequest = $request->withBody(Psr7\Utils::streamFor(Utils::jsonEncode($data)));
        $expectedResponse = $this->createResponse($expectedRequest->getBody());

        $httpClient = $this->createHttpClient($expectedRequest, $expectedResponse);
        $httpClient->addMiddleware($this->createMiddleware($expectedRequest));

        $response = $httpClient->sendRequest($request);

        $this->assertEquals($expectedResponse, $response);
    }

    private function createRequest(): Psr7\Request
    {
        $requestData = [
            'dp_command' => 'login',
            'dp_login' => 'login',
            'dp_password' => 'password',
        ];

        return new Psr7\Request('post', '', [], json_encode($requestData));
    }

    private function createResponse(StreamInterface $body): Psr7\Response
    {
        return new Psr7\Response(200, [], $body);
    }

    private function createHttpClient(RequestInterface $request, ResponseInterface $response): HttpClient
    {
        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock->method('sendRequest')->with($request)->willReturn($response);

        return new HttpClient($httpClientMock);
    }

    private function createMiddleware(RequestInterface $request): MiddlewareInterface
    {
        return new class($request) implements MiddlewareInterface {

            /** @var RequestInterface */
            private $request;

            public function __construct(RequestInterface $request)
            {
                $this->request = $request;
            }

            public function execute(RequestInterface $request, callable $next): ResponseInterface
            {
                return $next($this->request);
            }
        };
    }
}
