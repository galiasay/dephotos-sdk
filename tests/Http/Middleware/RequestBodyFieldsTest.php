<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Http\Middleware;

use Depositphotos\SDK\Http\Middleware\RequestBodyFields;
use Depositphotos\SDK\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class RequestBodyFieldsTest extends BaseTestCase
{
    public function testExecute(): void
    {
        $requestData = [
            'dp_command' => 'login',
            'dp_login' => 'login',
            'dp_password' => 'password',
        ];

        $newFields = [
            'dp_apikey' => uniqid(),
        ];

        $request = new Request('post', '', [], json_encode($requestData));
        $middleware = new RequestBodyFields($newFields);

        $expectedData = array_merge($newFields, $requestData);

        $middleware->execute($request, function (RequestInterface $request) use ($expectedData) {
            $this->assertEquals($expectedData, json_decode((string) $request->getBody(), true));
            return new Response();
        });
    }
}
