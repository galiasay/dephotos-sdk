<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\Purchase;

use Depositphotos\SDK\Resource\Regular\Purchase\Request\GetMediaRequest;
use Depositphotos\SDK\Resource\Regular\Purchase\Request\GetPurchasesRequest;
use Depositphotos\SDK\Resource\Regular\Purchase\Request\GetRestrictedSellersRequest;
use Depositphotos\SDK\Resource\Regular\Purchase\Request\ReDownloadRequest;
use Depositphotos\SDK\Resource\Regular\Purchase\Response\GetMediaResponse;
use Depositphotos\SDK\Resource\Regular\Purchase\Response\GetPurchasesResponse;
use Depositphotos\SDK\Resource\Regular\Purchase\Response\GetRestrictedSellersResponse;
use Depositphotos\SDK\Resource\Regular\Purchase\Response\ReDownloadResponse;
use Depositphotos\SDK\Resource\Resource;

class PurchaseResource extends Resource
{
    public function getMedia(GetMediaRequest $request): GetMediaResponse
    {
        $httpResponse = $this->send($request);

        return new GetMediaResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getRestrictedSellers(GetRestrictedSellersRequest $request): GetRestrictedSellersResponse
    {
        $httpResponse = $this->send($request);

        return new GetRestrictedSellersResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getPurchases(GetPurchasesRequest $request): GetPurchasesResponse
    {
        $httpResponse = $this->send($request);

        return new GetPurchasesResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function reDownload(ReDownloadRequest $request): ReDownloadResponse
    {
        $httpResponse = $this->send($request);

        return new ReDownloadResponse($this->convertHttpResponseToArray($httpResponse));
    }
}
