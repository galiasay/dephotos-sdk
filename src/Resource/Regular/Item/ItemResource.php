<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\Item;

use Depositphotos\SDK\Resource\Regular\Item\Request\CheckItemsStatusRequest;
use Depositphotos\SDK\Resource\Regular\Item\Request\GetFilesCountRequest;
use Depositphotos\SDK\Resource\Regular\Item\Request\GetFreeFilesRequest;
use Depositphotos\SDK\Resource\Regular\Item\Response\CheckItemsStatusResponse;
use Depositphotos\SDK\Resource\Regular\Item\Response\GetFilesCountResponse;
use Depositphotos\SDK\Resource\Regular\Item\Response\GetFreeFilesResponse;
use Depositphotos\SDK\Resource\Resource;

class ItemResource extends Resource
{
    public function checkItemsStatus(CheckItemsStatusRequest $request): CheckItemsStatusResponse
    {
        $httpResponse = $this->send($request);

        return new CheckItemsStatusResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getFilesCount(GetFilesCountRequest $request): GetFilesCountResponse
    {
        $httpResponse = $this->send($request);

        return new GetFilesCountResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getFreeFiles(GetFreeFilesRequest $request): GetFreeFilesResponse
    {
        $httpResponse = $this->send($request);

        return new GetFreeFilesResponse($this->convertHttpResponseToArray($httpResponse));
    }
}
