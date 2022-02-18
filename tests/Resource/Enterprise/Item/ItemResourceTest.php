<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Enterprise\Item;

use Depositphotos\SDK\Resource\Enterprise\Item\ItemResource;
use Depositphotos\SDK\Resource\Enterprise\Item\Request\ComplimentaryDownloadRequest;
use Depositphotos\SDK\Resource\Enterprise\Item\Request\GetGroupCompDownloadsRequest;
use Depositphotos\SDK\Resource\Enterprise\Item\Response\GetGroupCompDownloads\User;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class ItemResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testComplimentaryDownload(): void
    {
        $requestData = [
            'dp_command' => 'complimentaryDownload',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_item_id' => 123,
            'dp_option' => 'l',
        ];

        $responseData = [
            'type' => 'success',
            'downloadLink' => 'https://download....81097b25',
        ];

        $resource = new ItemResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->complimentaryDownload(new ComplimentaryDownloadRequest(
            $requestData['dp_session_id'],
            $requestData['dp_item_id'],
            $requestData['dp_option']
        ));

        $this->assertEquals($responseData['downloadLink'], $result->getDownloadUrl());
    }

    public function testGetGroupCompDownloads(): void
    {
        $requestData = [
            'dp_command' => 'getGroupCompDownloads',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_limit' => 10,
            'dp_offset' => 0,
            'dp_type' => ['image'],
            'dp_user_id' => null,
            'dp_group_id' => null,
            'dp_date_start' => '2022-01-01 00:00:00',
            'dp_date_end' => '2022-01-31 23:59:59',
        ];

        $responseData = [
            'type' => 'success',
            'downloads' => [
                [
                    'datetime' => 1471871234,
                    'filename' => 'File name here',
                    'groupId' => 12,
                    'itemId' => 12345678,
                    'marker' => 3,
                    'itemType' => 'video',
                    'preview' => 'http://st.depositphotos.com/123/linktofile/filename.jpg',
                    'width' => 1920,
                    'height' => 1080,
                    'userId' => 12345678,
                    'actor' => [
                        'id' => 12345678,
                        'username' => 'Usertest',
                    ],
                    'seller' => [
                        'id' => 12345678,
                        'username' => 'Usertest',
                    ],
                    'download' => 'http://st.depositphotos.com/storage/item/download?id=1234',
                    'visible' => true,
                ],
            ],
            'count' => 100,
        ];

        $resource = new ItemResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getGroupCompDownloads(new GetGroupCompDownloadsRequest(
            $requestData['dp_session_id'],
            $requestData['dp_limit'],
            $requestData['dp_offset'],
            $requestData['dp_type'],
            $requestData['dp_user_id'],
            $requestData['dp_group_id'],
            new \DateTime($requestData['dp_date_start']),
            new \DateTime($requestData['dp_date_end'])
        ));

        $this->assertEquals($responseData['count'], $result->getCount());
        foreach ($result->getDownloads() as $key => $download) {
            $this->assertEquals($responseData['downloads'][$key]['datetime'], $download->getUpdated()->getTimestamp());
            $this->assertEquals($responseData['downloads'][$key]['groupId'], $download->getGroupId());
            $this->assertEquals($responseData['downloads'][$key]['itemId'], $download->getItem()->getId());
            $this->assertEquals($responseData['downloads'][$key]['filename'], $download->getItem()->getFileName());
            $this->assertEquals($responseData['downloads'][$key]['marker'], $download->getMarker());
            $this->assertEquals($responseData['downloads'][$key]['itemType'], $download->getItem()->getType());
            $this->assertEquals($responseData['downloads'][$key]['preview'], $download->getItem()->getPreview());
            $this->assertEquals($responseData['downloads'][$key]['width'], $download->getItem()->getWidth());
            $this->assertEquals($responseData['downloads'][$key]['height'], $download->getItem()->getHeight());
            $this->assertEquals($responseData['downloads'][$key]['userId'], $download->getUserId());
            $this->assertUser($responseData['downloads'][$key]['actor'], $download->getActor());
            $this->assertUser($responseData['downloads'][$key]['seller'], $download->getSeller());
            $this->assertEquals($responseData['downloads'][$key]['download'], $download->getDownloadUrl());
            $this->assertEquals($responseData['downloads'][$key]['visible'], $download->getItem()->isVisible());
        }
    }

    private function assertUser(array $expected, User $user): void
    {
        $this->assertEquals($expected['id'], $user->getId());
        $this->assertEquals($expected['username'], $user->getUsername());
    }
}
