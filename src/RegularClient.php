<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Resource\Generic\Generic;

class RegularClient extends Client
{
    public function generic(): Generic
    {
        return new Generic($this->httpClient);
    }
}
