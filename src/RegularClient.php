<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Generic\GenericResource;
use Depositphotos\SDK\Resource\Regular\Item\ItemResource;
use Depositphotos\SDK\Resource\Regular\Legals\LegalsResource;
use Depositphotos\SDK\Resource\Regular\User\UserResource;

class RegularClient extends Client
{
    public function generic(): GenericResource
    {
        return new GenericResource($this->httpClient);
    }

    public function user(): UserResource
    {
        return new UserResource($this->httpClient);
    }

    public function item(): ItemResource
    {
        return new ItemResource($this->httpClient);
    }

    public function legals(): LegalsResource
    {
        return new LegalsResource($this->httpClient);
    }
}
