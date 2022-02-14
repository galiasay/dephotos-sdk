<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\Purchase\Response\GetChangedItemTransactions;

use Depositphotos\SDK\Resource\ResponseObject;
use DateTimeInterface;

class Transaction extends ResponseObject
{
    public function getId(): int
    {
        return (int) $this->getProperty('item_transaction_id');
    }

    public function getFromStatus(): string
    {
        return (string) $this->getProperty('status_from');
    }

    public function getToStatus(): string
    {
        return (string) $this->getProperty('status_to');
    }

    public function getChanged(): DateTimeInterface
    {
        return $this->getDateTime('date_changed');
    }

    public function getInfo(): TransactionInfo
    {
        return $this->getProperty('transaction_info', TransactionInfo::class);
    }
}
