<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enteprise\License\Response;

use Depositphotos\SDK\Resource\Enteprise\License\Response\GetTransferredLicenses\Transaction;
use Depositphotos\SDK\Resource\ResponseObject;

class GetTransferredLicensesResponse extends ResponseObject
{
    /**
     * @return Transaction[]
     */
    public function getTransactions(): array
    {
        return $this->getProperty('downloads', Transaction::class);
    }

    public function getCount(): int
    {
        return (int) $this->getProperty('count');
    }
}
