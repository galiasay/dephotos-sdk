<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Enterprise\Invoice\InvoiceResource;

class EnterpriseClient extends Client
{
    public function invoice(): InvoiceResource
    {
        return new InvoiceResource($this->httpClient);
    }
}
