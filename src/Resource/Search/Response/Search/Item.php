<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Search\Response\Search;

use Depositphotos\SDK\Resource\Search\Response\Common\Item as BaseItem;

class Item extends BaseItem
{
    /**
     * @return int[]
     */
    public function getSimilar(): array
    {
        return (array) $this->getProperty('similar');
    }

    /**
     * @return int[]
     */
    public function getSeries(): array
    {
        return (array) $this->getProperty('series');
    }

    /**
     * @return int[]
     */
    public function getSameModel(): array
    {
        return (array) $this->getProperty('same_model');
    }
}
