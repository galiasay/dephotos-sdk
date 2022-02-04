<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Search\Response;

use Depositphotos\SDK\Resource\Search\Response\GetSearchColors\Color;
use Depositphotos\SDK\Resource\ResponseObject;

class GetSearchColorsResponse extends ResponseObject
{
    /**
     * @return Color[]
     */
    public function getColors(): array
    {
        return (array) $this->getProperty('result', Color::class);
    }
}
