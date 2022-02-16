<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Item;

use Depositphotos\SDK\Resource\Item\ItemResource;
use Depositphotos\SDK\Resource\Item\Request\CheckItemsStatusRequest;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class ItemResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testCheckItemsStatus(): void
    {
        $requestData = [
            'dp_command' => 'checkItemsStatus',
            'dp_ids' => [1, 2, 3],
        ];

        $responseData = [
            'type' => 'success',
            'active' => [1, 2],
            'inactive' => [3],
        ];

        $resource = new ItemResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->checkItemsStatus(new CheckItemsStatusRequest($requestData['dp_ids']));

        $this->assertEquals($responseData['active'], $result->getActive());
        $this->assertEquals($responseData['inactive'], $result->getInactive());
    }
}
