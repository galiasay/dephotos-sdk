<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Enterprise\Statistics;

use Depositphotos\SDK\Resource\Enterprise\Statistics\Request\GetItemStatisticsRequest;
use Depositphotos\SDK\Resource\Enterprise\Statistics\Request\GetStatisticsRequest;
use Depositphotos\SDK\Resource\Enterprise\Statistics\Request\GetTotalStatisticsRequest;
use Depositphotos\SDK\Resource\Enterprise\Statistics\StatisticsResource;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class StatisticsResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testGetStatistics(): void
    {
        $requestData = [
            'dp_command' => 'getEnterpriseStatisticsDates',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_date_start' => '2022-01-01 00:00:00',
            'dp_date_end' => '2022-01-31 23:59:59',
            'dp_limit' => 10,
            'dp_offset' => 0,
            'dp_group_id' => null,
            'dp_user_id' => null,
        ];

        $responseData = [
            'type' => 'success',
            'data' => [
                [
                    'comps' => 0,
                    'licensed' => 1,
                    'transferred' => 0,
                    'title' => '2021-09-23 16:00:00',
                ],
            ],
            'count' => 1,
        ];

        $resource = new StatisticsResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getStatistics(new GetStatisticsRequest(
            $requestData['dp_session_id'],
            new \DateTime($requestData['dp_date_start']),
            new \DateTime($requestData['dp_date_end']),
            $requestData['dp_limit'],
            $requestData['dp_offset'],
            $requestData['dp_group_id'],
            $requestData['dp_user_id']
        ));

        $this->assertEquals($responseData['count'], $result->getCount());

        foreach ($result->getStatistics() as $key => $statistics) {
            $this->assertEquals($responseData['data'][$key]['comps'], $statistics->getComps());
            $this->assertEquals($responseData['data'][$key]['licensed'], $statistics->getLicensed());
            $this->assertEquals($responseData['data'][$key]['transferred'], $statistics->getTransferred());
            $this->assertEquals($responseData['data'][$key]['title'], $statistics->getTitle());
        }
    }

    public function testGetItemStatistics(): void
    {
        $requestData = [
            'dp_command' => 'getEnterpriseStatisticsItems',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_user_id' => 123,
            'dp_date_start' => '2022-01-01 00:00:00',
            'dp_date_end' => '2022-01-31 23:59:59',
            'dp_limit' => 10,
            'dp_offset' => 0,
        ];

        $responseData = [
            'type' => 'success',
            'data' => [
                [
                    'comps' => 0,
                    'licenses' => 1,
                    'transfers' => 0,
                    'id' => 11781,
                    'blocked' => false,
                    'height' => 2184,
                    'width' => 3276,
                    'type' => 'i',
                    'title' => 'Kitten',
                    'description' => 'Funny kitten one two three',
                    'filename' => 'stock-photo-kitten',
                    'sellerId' => 10958,
                    'sellerName' => 'seller',
                    'editorial' => false,
                    'mp' => 7.15,
                    'uploadTimestamp' => 1631718312,
                    'nudity' => false,
                ],
            ],
            'count' => 1,
        ];

        $resource = new StatisticsResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getItemStatistics(new GetItemStatisticsRequest(
            $requestData['dp_session_id'],
            $requestData['dp_user_id'],
            new \DateTime($requestData['dp_date_start']),
            new \DateTime($requestData['dp_date_end']),
            $requestData['dp_limit'],
            $requestData['dp_offset']
        ));

        $this->assertEquals($responseData['count'], $result->getCount());

        foreach ($result->getStatistics() as $key => $statistics) {
            $this->assertEquals($responseData['data'][$key]['comps'], $statistics->getComps());
            $this->assertEquals($responseData['data'][$key]['licenses'], $statistics->getLicenses());
            $this->assertEquals($responseData['data'][$key]['transfers'], $statistics->getTransfers());
            $this->assertEquals($responseData['data'][$key]['id'], $statistics->getId());
            $this->assertEquals($responseData['data'][$key]['blocked'], $statistics->isBlocked());
            $this->assertEquals($responseData['data'][$key]['height'], $statistics->getHeight());
            $this->assertEquals($responseData['data'][$key]['width'], $statistics->getWidth());
            $this->assertEquals($responseData['data'][$key]['type'], $statistics->getType());
            $this->assertEquals($responseData['data'][$key]['title'], $statistics->getTitle());
            $this->assertEquals($responseData['data'][$key]['description'], $statistics->getDescription());
            $this->assertEquals($responseData['data'][$key]['filename'], $statistics->getFilename());
            $this->assertEquals($responseData['data'][$key]['sellerId'], $statistics->getSellerId());
            $this->assertEquals($responseData['data'][$key]['sellerName'], $statistics->getSellerName());
            $this->assertEquals($responseData['data'][$key]['editorial'], $statistics->isEditorial());
            $this->assertEquals($responseData['data'][$key]['mp'], $statistics->getMp());
            $this->assertEquals($responseData['data'][$key]['uploadTimestamp'], $statistics->getUploaded()->getTimestamp());
            $this->assertEquals($responseData['data'][$key]['nudity'], $statistics->isNudity());
        }
    }

    public function testGetTotalStatistics(): void
    {
        $requestData = [
            'dp_command' => 'getEnterpriseStatisticsTotal',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_date_start' => '2022-01-01 00:00:00',
            'dp_date_end' => '2022-01-31 23:59:59',
            'dp_group_id' => null,
            'dp_user_id' => null,
        ];

        $responseData = [
            'type' => 'success',
            'comps' => 0,
            'licensed' => 1,
            'transferred' => 0,
        ];

        $resource = new StatisticsResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getTotalStatistics(new GetTotalStatisticsRequest(
            $requestData['dp_session_id'],
            new \DateTime($requestData['dp_date_start']),
            new \DateTime($requestData['dp_date_end']),
            $requestData['dp_group_id'],
            $requestData['dp_user_id']
        ));

        $this->assertEquals($responseData['comps'], $result->getComps());
        $this->assertEquals($responseData['licensed'], $result->getLicensed());
        $this->assertEquals($responseData['transferred'], $result->getTransferred());
    }
}
