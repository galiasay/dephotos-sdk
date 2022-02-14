<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\Purchase\Request\LicenseItem;

class LicensingInfo
{
    /** @var int[] */
    private $itemIds;

    /** @var string */
    private $size;

    /** @var int */
    private $licenseId;

    public function __construct(array $itemIds, string $size, int $licenseId)
    {
        $this->itemIds = $itemIds;
        $this->size = $size;
        $this->licenseId = $licenseId;
    }

    public function getItemIds(): array
    {
        return $this->itemIds;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getLicenseId(): int
    {
        return $this->licenseId;
    }
}
