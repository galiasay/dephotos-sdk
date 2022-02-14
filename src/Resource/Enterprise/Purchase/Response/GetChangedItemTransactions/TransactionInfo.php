<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\Purchase\Response\GetChangedItemTransactions;

use Depositphotos\SDK\Resource\ResponseObject;
use DateTimeInterface;

class TransactionInfo extends ResponseObject
{
    public function getTransactionId(): int
    {
        return (int) $this->getProperty('item_transaction_id');
    }

    public function getUserId(): int
    {
        return (int) $this->getProperty('user_id');
    }

    public function getMethod(): string
    {
        return (string) $this->getProperty('method');
    }

    public function getMethodId(): int
    {
        return (int) $this->getProperty('method_id');
    }

    public function getSize(): string
    {
        return (string) $this->getProperty('option');
    }

    public function getLicense(): string
    {
        return (string) $this->getProperty('license');
    }

    public function getItemId(): int
    {
        return (int) $this->getProperty('deposit_item_id');
    }

    public function getPrice(): float
    {
        return (float) $this->getProperty('price');
    }

    public function getBonusSize(): string
    {
        return (string) $this->getProperty('bonus_option');
    }

    public function getCreated(): DateTimeInterface
    {
        return $this->getDateTime('timestamp');
    }

    public function getStatus(): string
    {
        return (string) $this->getProperty('status');
    }

    public function getSubAccountId(): int
    {
        return (int) $this->getProperty('subaccount_id');
    }

    public function getFormat(): string
    {
        return (string) $this->getProperty('format');
    }
}
