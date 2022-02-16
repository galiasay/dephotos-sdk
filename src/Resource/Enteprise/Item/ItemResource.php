<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enteprise\Item;

use Depositphotos\SDK\Resource\Enteprise\Item\Request\GetLicensedItemsRequest;
use Depositphotos\SDK\Resource\Enteprise\Item\Response\GetLicensedItemsResponse;
use Depositphotos\SDK\Resource\Item\ItemResource as BaseItemResource;

class ItemResource extends BaseItemResource
{
    public function getLicensedItems(GetLicensedItemsRequest $request): GetLicensedItemsResponse
    {
        $httpResponse = $this->send($request);

        return new GetLicensedItemsResponse($this->convertHttpResponseToArray($httpResponse));
    }
}
