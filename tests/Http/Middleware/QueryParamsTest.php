<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Http\Middleware;

use Depositphotos\SDK\Http\Middleware\QueryParams;
use Depositphotos\SDK\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class QueryParamsTest extends BaseTestCase
{
    public function testExecute(): void
    {
        $params = [
            'param' => 'value',
        ];

        $newParams = [
            'newParam' => 'value2',
        ];

        $request = new Request('post', '?' . http_build_query($params));
        $middleware = new QueryParams($newParams);

        $expectedData = array_merge($newParams, $params);

        $middleware->execute($request, function (RequestInterface $request) use ($expectedData) {
            $this->assertEquals(http_build_query($expectedData), $request->getUri()->getQuery());
            return new Response();
        });
    }
}
