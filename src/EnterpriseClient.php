<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Enterprise\Item\ItemResource;
use Depositphotos\SDK\Resource\Enteprise\License\LicenseResource;
use Depositphotos\SDK\Resource\Enterprise\User\UserResource;

class EnterpriseClient extends Client
{
    public function item(): ItemResource
    {
        return new ItemResource($this->httpClient);
    }

    public function license(): LicenseResource
    {
        return new LicenseResource($this->httpClient);
    }

    public function user(): UserResource
    {
        return new UserResource($this->httpClient);
    }
}
