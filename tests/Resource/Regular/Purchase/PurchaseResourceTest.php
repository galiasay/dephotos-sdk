<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Regular\Purchase;

use Depositphotos\SDK\Resource\Regular\Purchase\PurchaseResource;
use Depositphotos\SDK\Resource\Regular\Purchase\Request\GetMediaRequest;
use Depositphotos\SDK\Resource\Regular\Purchase\Request\ReDownloadRequest;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class PurchaseResourceTest extends BaseTestCase
{
    use ResourceTrait;

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
