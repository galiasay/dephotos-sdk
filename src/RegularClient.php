<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Generic\GenericResource;
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
}
