<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource;

use Depositphotos\SDK\Exception\Exception;

class ResponseObject
{
    /** @var array */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function cast(string $class): ResponseObject
    {
        if (is_subclass_of($class, __CLASS__)) {
            return new $class($this->data);
        }

        throw new Exception('Cannot cast to an object');
    }

    /**
     * @return mixed
     */
    protected function getProperty(string $name, string $class = null)
    {
        $value = $this->data[$name] ?? null;

        if (is_array($value) && $class) {
            if ($this->isList($value)) {
                return array_map(function ($raw) use ($class) {
                    return (new ResponseObject($raw))->cast($class);
                }, $value);
            }

            return (new ResponseObject($value))->cast($class);
        }

        return $value;
    }

    private function isList(array $data): bool
    {
        return $data === [] || (array_keys($data) === range(0, count($data) - 1));
    }
}
