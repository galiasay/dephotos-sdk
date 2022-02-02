<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Regular\Purchase;

use Depositphotos\SDK\Resource\Regular\Purchase\PurchaseResource;
use Depositphotos\SDK\Resource\Regular\Purchase\Request\GetMediaRequest;
use Depositphotos\SDK\Resource\Regular\Purchase\Request\GetPurchasesRequest;
use Depositphotos\SDK\Resource\Regular\Purchase\Request\GetRestrictedSellersRequest;
use Depositphotos\SDK\Resource\Regular\Purchase\Request\ReDownloadRequest;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class PurchaseResourceTest extends BaseTestCase
{
    use ResourceTrait;

    private const DATE_FORMAT = 'M.d, Y H:i:s';

    public function testGetMedia(): void
    {
        $requestData = [
            'dp_command' => 'getMedia',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_media_id' => 1,
            'dp_media_option' => 'm',
            'dp_media_license' => 'standard',
            'dp_subscription_id' => null,
        ];

        $responseData = [
            'type' => 'success',
            'downloadLink' => 'https://download....81097b25',
            'licenseId' => 182395342,
            'method' => 'credits',
            'option' => 'm',
            'itemId' => 1,
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getMedia(new GetMediaRequest(
            $requestData['dp_session_id'],
            $requestData['dp_media_id'],
            $requestData['dp_media_option'],
            $requestData['dp_media_license'],
            $requestData['dp_subscription_id']
        ));

        $this->assertEquals($responseData['downloadLink'], $result->getDownloadLink());
        $this->assertEquals($responseData['licenseId'], $result->getLicenseId());
        $this->assertEquals($responseData['method'], $result->getMethod());
        $this->assertEquals($responseData['option'], $result->getOption());
        $this->assertEquals($responseData['itemId'], $result->getItemId());
    }

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

        foreach ($result->getPurchases() as $key => $item) {
            $this->assertEquals($responseData['purchases'][$key]['mediaId'], $item->getId());
            $this->assertEquals($responseData['purchases'][$key]['license'], $item->getLicense());
            $this->assertEquals($responseData['purchases'][$key]['size'], $item->getSize());
            $this->assertEquals($responseData['purchases'][$key]['price'], $item->getPrice());
            $this->assertEquals($responseData['purchases'][$key]['method'], $item->getMethod());
            $this->assertEquals($responseData['purchases'][$key]['purchaseDate'], $item->getPurchaseDate()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['purchases'][$key]['licenseId'], $item->getLicenseId());
            $this->assertEquals($responseData['purchases'][$key]['purchasedWidth'], $item->getPurchasedWidth());
            $this->assertEquals($responseData['purchases'][$key]['purchasedHeight'], $item->getPurchasedHeight());
            $this->assertEquals($responseData['purchases'][$key]['title'], $item->getTitle());
            $this->assertEquals($responseData['purchases'][$key]['description'], $item->getDescription());
            $this->assertEquals($responseData['purchases'][$key]['status'], $item->getStatus());
            $this->assertEquals($responseData['purchases'][$key]['width'], $item->getWidth());
            $this->assertEquals($responseData['purchases'][$key]['height'], $item->getHeight());
            $this->assertEquals($responseData['purchases'][$key]['mp'], $item->getMp());
            $this->assertEquals($responseData['purchases'][$key]['views'], $item->getViews());
            $this->assertEquals($responseData['purchases'][$key]['downloads'], $item->getDownloads());
            $this->assertEquals($responseData['purchases'][$key]['username'], $item->getUsername());
            $this->assertEquals($responseData['purchases'][$key]['level'], $item->getLevel());
            $this->assertEquals($responseData['purchases'][$key]['userid'], $item->getUserId());
            $this->assertEquals($responseData['purchases'][$key]['published'], $item->getPublished()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['purchases'][$key]['updated'], $item->getUpdated()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['purchases'][$key]['iseditorial'], $item->isEditorial());
            $this->assertEquals($responseData['purchases'][$key]['itype'], $item->getType());
            $this->assertEquals($responseData['purchases'][$key]['thumbnail'], $item->getThumbnail());
            $this->assertEquals($responseData['purchases'][$key]['medium_thumbnail'], $item->getMediumThumbnail());
            $this->assertEquals($responseData['purchases'][$key]['large_thumb'], $item->getLargeThumbnail());
            $this->assertEquals($responseData['purchases'][$key]['huge_thumb'], $item->getHugeThumbnail());
            $this->assertEquals($responseData['purchases'][$key]['url'], $item->getUrl());
            $this->assertEquals($responseData['purchases'][$key]['url2'], $item->getUrl2());
            $this->assertEquals($responseData['purchases'][$key]['url_big'], $item->getBigUrl());
            $this->assertEquals($responseData['purchases'][$key]['url_max_qa'], $item->getMaxQaUrl());
            $this->assertEquals($responseData['purchases'][$key]['itemurl'], $item->getItemUrl());
            $this->assertEquals($responseData['purchases'][$key]['isFreeItem'], $item->isFreeItem());
        }
    }

    public function testReDownload(): void
    {
        $requestData = [
            'dp_command' => 'reDownload',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_license_id' => 1,
            'dp_subaccount_id' => null,
            'dp_subaccount_license_id' => null,
        ];

        $responseData = [
            'type' => 'success',
            'downloadLink' => 'https://download....81097b25',
            'licenseId' => 182395342,
            'method' => 'credits',
            'option' => 'm',
            'itemId' => 1,
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->reDownload(new ReDownloadRequest(
            $requestData['dp_session_id'],
            $requestData['dp_license_id'],
            $requestData['dp_subaccount_id'],
            $requestData['dp_subaccount_license_id']
        ));

        $this->assertEquals($responseData['downloadLink'], $result->getDownloadLink());
        $this->assertEquals($responseData['licenseId'], $result->getLicenseId());
        $this->assertEquals($responseData['method'], $result->getMethod());
        $this->assertEquals($responseData['option'], $result->getOption());
        $this->assertEquals($responseData['itemId'], $result->getItemId());
    }
}
