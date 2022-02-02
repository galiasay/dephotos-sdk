<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\Purchase\Response;

use Depositphotos\SDK\Resource\Regular\Purchase\Response\GetPurchases\Item;
use Depositphotos\SDK\Resource\ResponseObject;

class GetPurchasesResponse extends ResponseObject
{
    /**
     * @return Item[]
     */
    public function getPurchases(): array
    {
        return (array) $this->getProperty('purchases', Item::class);
    }

    public function getCount(): int
    {
        return (int) $this->getProperty('count');
    }
}
