<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\Invoice\Response;

use Depositphotos\SDK\Resource\ResponseObject;

class GetInvoiceCountResponse extends ResponseObject
{
    public function getCount(): int
    {
        return (int) $this->getProperty('count');
    }
}
