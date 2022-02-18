<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Enterprise\Item\ItemResource;
use Depositphotos\SDK\Resource\Enterprise\License\LicenseResource;
use Depositphotos\SDK\Resource\Enterprise\User\UserResource;
use Depositphotos\SDK\Resource\Enterprise\Invoice\InvoiceResource;

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

    public function invoice(): InvoiceResource
    {
        return new InvoiceResource($this->httpClient);
    }
}
