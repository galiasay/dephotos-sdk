<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Common\Purchase;

use Depositphotos\SDK\Resource\Common\Purchase\PurchaseResource;
use Depositphotos\SDK\Resource\Common\Purchase\Request\GetPurchasesRequest;
use Depositphotos\SDK\Resource\Common\Purchase\Request\GetRestrictedSellersRequest;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class PurchaseResourceTest extends BaseTestCase
{
    use ResourceTrait;

    private const DATE_FORMAT = 'M.d, Y H:i:s';

    public function testGetRestrictedSellers(): void
    {
        $requestData = [
            'dp_command' => 'getRestrictedSellers',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
        ];

        $responseData = [
            'type' => 'success',
            'restricted_sellers' => [1, 2],
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getRestrictedSellers(new GetRestrictedSellersRequest(
            $requestData['dp_session_id']
        ));

        $this->assertEquals($responseData['restricted_sellers'], $result->getRestrictedSellers());
    }

    public function testGetPurchases(): void
    {
        $requestData = [
            'dp_command' => 'getPurchases',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_limit' => 1,
            'dp_offset' => 0,
            'dp_sort_field' => 'timestamp',
            'dp_sort_type' => 'desc',
            'dp_item_id' => null,
            'dp_size' => null,
            'dp_datetime_format' => null,
        ];

        $responseData = [
            'type' => 'success',
            'purchases' => [
                [
                    'mediaId' => '32003469',
                    'license' => 'standard',
                    'size' => 'm',
                    'price' => '4.68',
                    'method' => 'ondemand',
                    'purchaseDate' => 'Feb.24, 2017 16:15:44',
                    'licenseId' => '64781356',
                    'purchasedWidth' => '1000',
                    'purchasedHeight' => '750',
                    'title' => 'Jmngfnf',
                    'description' => 'Hndttrntrfbn ethrtjrthn',
                    'status' => 'active',
                    'width' => '3200',
                    'height' => '2400',
                    'mp' => '7.68',
                    'views' => 2,
                    'downloads' => 6,
                    'username' => 'tester-seller6',
                    'level' => 'beginner',
                    'userid' => 3212109,
                    'published' => 'Jun.02, 2014 15:00:50',
                    'updated' => 'May.16, 2017 15:06:04',
                    'iseditorial' => false,
                    'itype' => 'image',
                    'thumbnail' => 'https://thumbs.depositphotos.net/thumbs/3212109/image/3200/32003469/thumb_110.jpg',
                    'medium_thumbnail' => 'https://thumbs.depositphotos.net/thumbs/3212109/image/3200/32003469/thumb_170.jpg',
                    'large_thumb' => 'https://thumbs.depositphotos.net/3212109/3200/i/380/depositphotos_32003469-stock-photo-jmngfnf.jpg',
                    'huge_thumb' => 'https://thumbs.depositphotos.net/3212109/3200/i/450/depositphotos_32003469-stock-photo-jmngfnf.jpg',
                    'url' => 'https://thumbs.depositphotos.net/thumbs/3212109/image/3200/32003469/thumb_110.jpg',
                    'url2' => 'https://thumbs.depositphotos.net/thumbs/3212109/image/3200/32003469/api_thumb_450.jpg',
                    'url_big' => 'https://thumbs.depositphotos.net/3212109/3200/i/950/depositphotos_32003469-stock-photo-jmngfnf.jpg',
                    'url_max_qa' => 'https://thumbs.depositphotos.net/3212109/3200/i/950/depositphotos_32003469-stock-photo-jmngfnf.jpg',
                    'itemurl' => 'http://api.iharmider.dev/32003469/stock-photo-jmngfnf.html',
                    'isFreeItem' => false
                ],
            ],
            'count' => 100
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $request = new GetPurchasesRequest(
            $requestData['dp_session_id'],
            $requestData['dp_limit'],
            $requestData['dp_offset']
        );
        $request
            ->setSortField($requestData['dp_sort_field'])
            ->setSortType($requestData['dp_sort_type']);
        $result = $resource->getPurchases($request);

        $this->assertEquals($responseData['count'], $result->getCount());

        foreach ($result->getPurchases() as $key => $purchase) {
            $this->assertEquals($responseData['purchases'][$key]['license'], $purchase->getLicense());
            $this->assertEquals($responseData['purchases'][$key]['size'], $purchase->getSize());
            $this->assertEquals($responseData['purchases'][$key]['price'], $purchase->getPrice());
            $this->assertEquals($responseData['purchases'][$key]['method'], $purchase->getMethod());
            $this->assertEquals($responseData['purchases'][$key]['purchaseDate'], $purchase->getPurchased()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['purchases'][$key]['licenseId'], $purchase->getLicenseId());
            $this->assertEquals($responseData['purchases'][$key]['purchasedWidth'], $purchase->getPurchasedWidth());
            $this->assertEquals($responseData['purchases'][$key]['purchasedHeight'], $purchase->getPurchasedHeight());
            $this->assertEquals($responseData['purchases'][$key]['status'], $purchase->getStatus());
            $this->assertEquals($responseData['purchases'][$key]['mediaId'], $purchase->getItem()->getId());
            $this->assertEquals($responseData['purchases'][$key]['title'], $purchase->getItem()->getTitle());
            $this->assertEquals($responseData['purchases'][$key]['description'], $purchase->getItem()->getDescription());
            $this->assertEquals($responseData['purchases'][$key]['width'], $purchase->getItem()->getWidth());
            $this->assertEquals($responseData['purchases'][$key]['height'], $purchase->getItem()->getHeight());
            $this->assertEquals($responseData['purchases'][$key]['views'], $purchase->getItem()->getViews());
            $this->assertEquals($responseData['purchases'][$key]['mp'], $purchase->getItem()->getMp());
            $this->assertEquals($responseData['purchases'][$key]['downloads'], $purchase->getItem()->getDownloads());
            $this->assertEquals($responseData['purchases'][$key]['username'], $purchase->getItem()->getUsername());
            $this->assertEquals($responseData['purchases'][$key]['level'], $purchase->getItem()->getLevel());
            $this->assertEquals($responseData['purchases'][$key]['userid'], $purchase->getItem()->getUserId());
            $this->assertEquals($responseData['purchases'][$key]['published'], $purchase->getItem()->getPublished()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['purchases'][$key]['updated'], $purchase->getItem()->getUpdated()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['purchases'][$key]['iseditorial'], $purchase->getItem()->isEditorial());
            $this->assertEquals($responseData['purchases'][$key]['itype'], $purchase->getItem()->getType());
            $this->assertEquals($responseData['purchases'][$key]['thumbnail'], $purchase->getItem()->getThumbnail());
            $this->assertEquals($responseData['purchases'][$key]['medium_thumbnail'], $purchase->getItem()->getMediumThumbnail());
            $this->assertEquals($responseData['purchases'][$key]['large_thumb'], $purchase->getItem()->getLargeThumbnail());
            $this->assertEquals($responseData['purchases'][$key]['huge_thumb'], $purchase->getItem()->getHugeThumbnail());
            $this->assertEquals($responseData['purchases'][$key]['url'], $purchase->getItem()->getUrl());
            $this->assertEquals($responseData['purchases'][$key]['url2'], $purchase->getItem()->getUrl2());
            $this->assertEquals($responseData['purchases'][$key]['url_big'], $purchase->getItem()->getBigUrl());
            $this->assertEquals($responseData['purchases'][$key]['url_max_qa'], $purchase->getItem()->getMaxQaUrl());
            $this->assertEquals($responseData['purchases'][$key]['itemurl'], $purchase->getItem()->getItemUrl());
            $this->assertEquals($responseData['purchases'][$key]['isFreeItem'], $purchase->getItem()->isFreeItem());
        }
    }
}
