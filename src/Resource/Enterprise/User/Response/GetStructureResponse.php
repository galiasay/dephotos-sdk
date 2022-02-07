<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\User\Response;

use Depositphotos\SDK\Resource\Enterprise\User\Response\GetStructure\Group;
use Depositphotos\SDK\Resource\ResponseObject;

class GetStructureResponse extends ResponseObject
{
    /**
     * @return Group[]
     */
    public function getGroups(): array
    {
        return (array) $this->getProperty('data', Group::class);
    }

    public function getCount(): int
    {
        return (int) $this->getProperty('count');
    }
}
