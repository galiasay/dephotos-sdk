<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource;

interface RequestInterface
{
    /**
     * @return mixed[]
     */
    public function toArray(): array;
}
