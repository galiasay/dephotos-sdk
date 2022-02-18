<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Item;

use Depositphotos\SDK\Resource\Item\Request\CheckItemsStatusRequest;
use Depositphotos\SDK\Resource\Item\Response\CheckItemsStatusResponse;
use Depositphotos\SDK\Resource\Resource;

class ItemResource extends Resource
{
    public function checkItemsStatus(CheckItemsStatusRequest $request): CheckItemsStatusResponse
    {
        $httpResponse = $this->send($request);

        return new CheckItemsStatusResponse($this->convertHttpResponseToArray($httpResponse));
    }
}
