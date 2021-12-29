<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Generic\Response;

class GetInfoResponse
{
    /** @var int */
    private $totalFiles;

    /** @var int */
    private $totalWeekFiles;

    public function __construct(int $totalFiles, int $totalWeekFiles)
    {
        $this->totalFiles = $totalFiles;
        $this->totalWeekFiles = $totalWeekFiles;
    }

    public static function create(array $data): self
    {
        return new self((int) ($data['totalFiles'] ?? 0), (int) ($data['totalWeekFiles'] ?? 0));
    }

    public function getTotalFiles(): int
    {
        return $this->totalFiles;
    }

    public function getTotalWeekFiles(): int
    {
        return $this->totalWeekFiles;
    }
}
