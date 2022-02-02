<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Regular\Tools;

use Depositphotos\SDK\Resource\Regular\Tools\Request\RemoveBg\Url;
use Depositphotos\SDK\Resource\Regular\Tools\Request\RemoveBgRequest;
use Depositphotos\SDK\Resource\Regular\Tools\ToolsResource;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;

class ToolsResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testRemoveBg(): void
    {
        $requestData = [
            'dp_command' => 'removeBg',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_image_url' => 'http://path/to/image',
        ];

        $response = new Response(200, [
            'Content-Type' => 'image/png',
            'X-Width' => 200,
            'X-Height' => 300,
        ], $this->createMock(StreamInterface::class));

        $resource = new ToolsResource($this->createHttpClient($requestData, $response));
        $result = $resource->removeBg(new RemoveBgRequest(
            $requestData['dp_session_id'],
            new Url($requestData['dp_image_url']))
        );

        $this->assertEquals($response->getHeaderLine('Content-Type'), $result->getContentType());
        $this->assertEquals($response->getHeaderLine('X-Width'), $result->getWidth());
        $this->assertEquals($response->getHeaderLine('X-Height'), $result->getHeight());
    }
}
