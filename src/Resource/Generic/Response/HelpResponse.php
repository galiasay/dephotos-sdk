<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Generic\Response;

use Depositphotos\SDK\Resource\Generic\Response\DTO\ExceptionDTO;

class HelpResponse
{
    /** @var string */
    private $method;

    /** @var string */
    private $description;

    /** @var string */
    private $longDescription;

    /** @var ExceptionDTO[] */
    private $exceptions = [];

    public function __construct(string $method, string $description, string $longDescription, array $exceptions)
    {
        $this->method = $method;
        $this->description = $description;
        $this->longDescription = $longDescription;
        $this->addExceptions($exceptions);
    }

    public static function create(array $data): self
    {
        $exceptions = [];

        foreach ((array) ($data['help']['exception'] ?? []) as $exception) {
            $type = (string) ($exception['type'] ?? '');

            if ($type) {
                $exceptions[] = new ExceptionDTO($type, (string) ($exception['description'] ?? ''));
            }
        }

        return new self(
            (string) ($data['help']['method'] ?? ''),
            (string) ($data['help']['description'] ?? ''),
            (string) ($data['help']['longDescription'] ?? ''),
            $exceptions
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

    /**
     * @param ExceptionDTO[] $exceptions
     */
    private function addExceptions(array $exceptions): void
    {
        foreach ($exceptions as $exception) {
            $this->addException($exception);
        }
    }

    private function addException(ExceptionDTO $exception): self
    {
        $this->exceptions[] = $exception;

        return $this;
    }
}
