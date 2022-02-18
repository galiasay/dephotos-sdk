<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Regular\Item;

use Depositphotos\SDK\Resource\Regular\Item\ItemResource;
use Depositphotos\SDK\Resource\Regular\Item\Request\GetFilesCountRequest;
use Depositphotos\SDK\Resource\Regular\Item\Request\GetFreeFilesRequest;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class ItemResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testGetFilesCount(): void
    {
        $requestData = [
            'dp_command' => 'getFilesCount',
            'dp_type' => 'image',
        ];

        $responseData = [
            'type' => 'success',
            'itemType' => 'image',
            'count' => 145964221,
            'contributorsCount' => 93290,
            'freeItemsCount' => 64701,
            'curatedItemsCount' => 573483,
            'customers' => 13460684,
            'free' => [
                'total' => 64701,
                'image' => 22340,
                'vector' => 14252,
                'video' => 16097,
                'editorial' => 12012,
            ]
        ];

        $resource = new ItemResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getFilesCount(new GetFilesCountRequest($requestData['dp_type']));

        $this->assertEquals($responseData['itemType'], $result->getItemType());
        $this->assertEquals($responseData['count'], $result->getCount());
        $this->assertEquals($responseData['contributorsCount'], $result->getContributorsCount());
        $this->assertEquals($responseData['freeItemsCount'], $result->getFreeItemsCount());
        $this->assertEquals($responseData['curatedItemsCount'], $result->getCuratedItemsCount());
        $this->assertEquals($responseData['customers'], $result->getCustomers());
        $this->assertEquals($responseData['free']['total'], $result->getFree()->getTotal());
        $this->assertEquals($responseData['free']['image'], $result->getFree()->getImage());
        $this->assertEquals($responseData['free']['vector'], $result->getFree()->getVector());
        $this->assertEquals($responseData['free']['video'], $result->getFree()->getVideo());
        $this->assertEquals($responseData['free']['editorial'], $result->getFree()->getEditorial());
    }

    public function testGetFreeFiles(): void
    {
        $requestData = [
            'dp_command' => 'getFreeFiles',
            'dp_limit' => 2,
            'dp_offset' => 0,
            'dp_shuffle' => false,
            'dp_type' => 'image',
        ];

        $responseData = [
            'type' => 'success',
            'items' => [
                [
                    'alt' => null,
                    'title' => 'Footpath',
                    'description' => 'Winter footpath in city. A snow landscape',
                    'filename' => 'stock-photo-footpath',
                    'thumbSource' => 'static3.depositphotos.com',
                    'id' => 6542,
                    'blocked' => false,
                    'height' => 3300,
                    'width' => 2208,
                    'type' => 'image',
                    'sellerId' => 1431,
                    'sellerName' => 'Valeriy_Al',
                    'editorial' => false,
                    'mp' => 7.29,
                    'uploadTimestamp' => 1258050026,
                    'nudity' => false,
                    'royaltyModel' => 'cpa',
                    'thumbUrl' => 'https://static3.depositphotos.com/thumbs/1431/image/103/6542/thumb_110.jpg?forcejpeg=true',
                    'thumbBigUrl' => 'https://static3.depositphotos.com/1431/103/i/950/6542-stock-photo-footpath.jpg?forcejpeg=true',
                    'thumb_medium' => 'https://static3.depositphotos.com/thumbs/1431/image/103/6542/thumb_170.jpg?forcejpeg=true',
                    'thumb_huge' => 'https://static3.depositphotos.com/thumbs/1431/image/103/6542/thumb_450.jpg?forcejpeg=true',
                    'thumb_max' => 'https://static3.depositphotos.com/1431/103/i/950/depositphotos_6542-stock-photo-footpath.jpg?forcejpeg=true',
                ],
                [
                    'alt' => null,
                    'title' => 'Phone, glasses, pencil',
                    'description' => 'Office attributes on a table',
                    'filename' => 'stock-photo-phone-glasses-pencil',
                    'thumbSource' => 'static3.depositphotos.com',
                    'id' => 54213,
                    'blocked' => false,
                    'height' => 2427,
                    'width' => 3626,
                    'type' => 'image',
                    'sellerId' => 154,
                    'sellerName' => 'Valeriy_Al',
                    'editorial' => false,
                    'mp' => 8.8,
                    'uploadTimestamp' => 1258051209,
                    'nudity' => false,
                    'royaltyModel' => 'cpa',
                    'thumbUrl' => 'https://static3.depositphotos.com/thumbs/154/image/103/54213/thumb_110.jpg?forcejpeg=true',
                    'thumbBigUrl' => 'https://static3.depositphotos.com/154/103/i/950/54213-stock-photo-phone-glasses-pencil.jpg?forcejpeg=true',
                    'thumb_medium' => 'https://static3.depositphotos.com/thumbs/154/image/103/54213/thumb_170.jpg?forcejpeg=true',
                    'thumb_huge' => 'https://static3.depositphotos.com/thumbs/154/image/103/54213/thumb_450.jpg?forcejpeg=true',
                    'thumb_max' => 'https://static3.depositphotos.com/154/103/i/950/depositphotos_54213-stock-photo-phone-glasses-pencil.jpg?forcejpeg=true',
                ],
            ],
            'count' => 20,
        ];

        $resource = new ItemResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getFreeFiles(new GetFreeFilesRequest(
            $requestData['dp_limit'],
            $requestData['dp_offset'],
            $requestData['dp_shuffle'],
            $requestData['dp_type']
        ));

        $this->assertEquals($responseData['count'], $result->getCount());

        foreach ($result->getItems() as $key => $item) {
            $this->assertEquals($responseData['items'][$key], [
                'alt' => $item->getAlt(),
                'title' => $item->getTitle(),
                'description' => $item->getDescription(),
                'filename' => $item->getFilename(),
                'thumbSource' => $item->getThumbSource(),
                'id' => $item->getId(),
                'blocked' => $item->isBlocked(),
                'height' => $item->getHeight(),
                'width' => $item->getWidth(),
                'type' => $item->getType(),
                'sellerId' => $item->getSellerId(),
                'sellerName' => $item->getSellerName(),
                'editorial' => $item->isEditorial(),
                'mp' => $item->getMp(),
                'uploadTimestamp' => $item->getUploadDate()->getTimestamp(),
                'nudity' => $item->isNudity(),
                'royaltyModel' => $item->getRoyaltyModel(),
                'thumbUrl' => $item->getThumbnail(),
                'thumbBigUrl' => $item->getBigThumbnail(),
                'thumb_medium' => $item->getMediumThumbnail(),
                'thumb_huge' => $item->getHugeThumbnail(),
                'thumb_max' => $item->getMaxThumbnail(),
            ]);
        }
    }
}
