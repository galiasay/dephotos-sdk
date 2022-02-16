<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enteprise\Item\Response\GetLicensedItems;

use Depositphotos\SDK\Resource\ResponseObject;

class User extends ResponseObject
{
    public function getId(): int
    {
        return (int) $this->getProperty('id');
    }

    public function getUsername(): string
    {
        return (string) $this->getProperty('username');
    }
}
