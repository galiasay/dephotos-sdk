<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Enterprise\User\UserResource;

class EnterpriseClient extends Client
{
    public function user(): UserResource
    {
        return new UserResource($this->httpClient);
    }
}
