<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Generic;

use Depositphotos\SDK\Resource\Generic\Response\DTO\ExceptionDTO;
use Depositphotos\SDK\Resource\Generic\Generic;
use Depositphotos\SDK\Resource\Generic\Request\GetInfoRequest;
use Depositphotos\SDK\Resource\Generic\Request\HelpRequest;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class GenericTest extends BaseTestCase
{
    use ResourceTrait;

    public function testGetInfo(): void
    {
        $requestData = [
            'dp_command' => 'getInfo',
        ];

        $responseData = [
            'type' => 'success',
            'totalFiles' => rand(1000, 10000),
            'totalWeekFiles' => rand(100, 1000),
        ];

        $resource = new Generic($this->createHttpClient($requestData, $responseData));
        $result = $resource->getInfo(new GetInfoRequest());

        $this->assertEquals($responseData['totalFiles'], $result->getTotalFiles());
        $this->assertEquals($responseData['totalWeekFiles'], $result->getTotalWeekFiles());
    }

    public function testHelp(): void
    {
        $requestData = [
            'dp_command' => 'help',
            'dp_by_command' => 'login',
        ];

        $responseData = [
            'type' => 'success',
            'help' => [
                'method' => 'login',
                'description' => 'Authentication method',
                'longDescription' => 'Authentication of an API client by the specified username and password',
                'exception' => [
                    [
                        'type' => 'EInternal\\InvalidParam',
                        'description' => '',
                    ],
                    [
                        'type' => 'EUser\\Authentication',
                        'description' => '',
                    ],
                ],
            ],
        ];

        $resource = new Generic($this->createHttpClient($requestData, $responseData));
        $result = $resource->help(new HelpRequest($requestData['dp_by_command']));

        $this->assertEquals($responseData['help']['method'], $result->getMethod());
        $this->assertEquals($responseData['help']['description'], $result->getDescription());
        $this->assertEquals($responseData['help']['longDescription'], $result->getLongDescription());
        $this->assertEquals($responseData['help']['exception'], array_map(function (ExceptionDTO $exceptionDTO) {
            return [
                'type' => $exceptionDTO->getType(),
                'description' => $exceptionDTO->getDescription(),
            ];
        }, $result->getExceptions()));
    }
}
