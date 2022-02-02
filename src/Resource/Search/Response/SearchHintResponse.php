<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Search\Response;

use Depositphotos\SDK\Resource\ResponseObject;

class SearchHintResponse extends ResponseObject
{
    /**
     * @return string[]
     */
    public function getHints(): array
    {
        return (array) $this->getProperty('hints');
    }

    public function getPrefix(): string
    {
        return (string) $this->getProperty('prefix');
    }
}
