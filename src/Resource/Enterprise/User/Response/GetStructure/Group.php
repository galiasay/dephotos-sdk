<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\User\Response\GetStructure;

use Depositphotos\SDK\Resource\ResponseObject;

class Group extends ResponseObject
{
    public function getId(): int
    {
        return (int) $this->getProperty('id');
    }

    public function getStatus(): string
    {
        return (string) $this->getProperty('status');
    }

    public function getName(): string
    {
        return (string) $this->getProperty('name');
    }

    public function isShowTransferLicenses(): bool
    {
        return (bool) $this->getProperty('showTransferLicenses');
    }

    public function getOverdraft(): float
    {
        return (float) $this->getProperty('overdraft');
    }
}
