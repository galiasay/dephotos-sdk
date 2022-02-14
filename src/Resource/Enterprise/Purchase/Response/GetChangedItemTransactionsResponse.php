<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\Purchase\Response;

use Depositphotos\SDK\Resource\Enterprise\Purchase\Response\GetChangedItemTransactions\Transaction;
use Depositphotos\SDK\Resource\ResponseObject;

class GetChangedItemTransactionsResponse extends ResponseObject
{
    /**
     * @return Transaction[]
     */
    public function getTransactions(): array
    {
        return (array) $this->getProperty('result', Transaction::class);
    }
}
