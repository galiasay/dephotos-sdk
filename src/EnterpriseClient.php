<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Enteprise\License\LicenseResource;

class EnterpriseClient extends Client
{
    public function license(): LicenseResource
    {
        return new LicenseResource($this->httpClient);
    }
}
