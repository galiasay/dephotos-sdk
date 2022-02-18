<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Enterprise\Item\ItemResource;

class EnterpriseClient extends Client
{
    public function item(): ItemResource
    {
        return new ItemResource($this->httpClient);
    }
}
