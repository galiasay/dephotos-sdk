<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Search\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class GetSearchColorsRequest implements RequestInterface
{
    private const COMMAND_NAME = 'getSearchColors';

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
        ];
    }
}
