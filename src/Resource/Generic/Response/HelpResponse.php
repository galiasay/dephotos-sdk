<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Generic\Response;

use Depositphotos\SDK\Resource\Generic\DTO\ExceptionDTO;

class HelpResponse
{
    /** @var string */
    private $method;

    /** @var string */
    private $description;

    /** @var string */
    private $longDescription;

    /** @var ExceptionDTO[] */
    private $exceptions;

    public function __construct(string $method, string $description, string $longDescription, array $exceptions)
    {
        $this->method = $method;
        $this->description = $description;
        $this->longDescription = $longDescription;

        foreach ($exceptions as $exception) {
            $type = (string) ($exception['type'] ?? '');

            if ($type) {
                $this->addException($type, (string) ($exception['description'] ?? ''));
            }
        }
    }

    public static function create(array $data): self
    {
        return new self(
            (string) ($data['help']['method'] ?? ''),
            (string) ($data['help']['description'] ?? ''),
            (string) ($data['help']['longDescription'] ?? ''),
            (array) ($data['help']['exception'] ?? [])
        );
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLongDescription(): string
    {
        return $this->longDescription;
    }

    /**
     * @return ExceptionDTO[]
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }

    private function addException(string $type, string $description): self
    {
        $this->exceptions[] = new ExceptionDTO($type, $description);

        return $this;
    }
}
