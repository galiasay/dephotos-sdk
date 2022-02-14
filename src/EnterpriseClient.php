<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Enterprise\Purchase\PurchaseResource;

class EnterpriseClient extends Client
{
    public function purchase(): PurchaseResource
    {
        return new PurchaseResource($this->httpClient);
    }
}
