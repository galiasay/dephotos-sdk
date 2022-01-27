<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\Purchase\Response\GetPurchases;

use Depositphotos\SDK\Resource\ResponseObject;

class Item extends ResponseObject
{
    public function getMediaId(): int
    {
        return (int) $this->getProperty('mediaId');
    }

    public function getLicense(): string
    {
        return (string) $this->getProperty('license');
    }

    public function getSize(): string
    {
        return (string) $this->getProperty('size');
    }

    public function getPrice(): float
    {
        return (float) $this->getProperty('price');
    }

    public function getMethod(): string
    {
        return (string) $this->getProperty('method');
    }

    public function getPurchaseDate(): \DateTimeInterface
    {
        return $this->getDateTime('purchaseDate');
    }

    public function getLicenseId(): int
    {
        return (int) $this->getProperty('licenseId');
    }

    public function getPurchasedWidth(): int
    {
        return (int) $this->getProperty('purchasedWidth');
    }

    public function getPurchasedHeight(): int
    {
        return (int) $this->getProperty('purchasedHeight');
    }

    public function getTitle(): string
    {
        return (string) $this->getProperty('title');
    }

    public function getDescription(): string
    {
        return (string) $this->getProperty('description');
    }

    public function getStatus(): string
    {
        return (string) $this->getProperty('status');
    }

    public function getWidth(): int
    {
        return (int) $this->getProperty('width');
    }

    public function getHeight(): int
    {
        return (int) $this->getProperty('height');
    }

    public function getMp(): float
    {
        return (float) $this->getProperty('mp');
    }

    public function getViews(): int
    {
        return (int) $this->getProperty('views');
    }

    public function getDownloads(): int
    {
        return (int) $this->getProperty('downloads');
    }

    public function getUsername(): string
    {
        return (string) $this->getProperty('username');
    }

    public function getLevel(): string
    {
        return (string) $this->getProperty('level');
    }

    public function getUserId(): int
    {
        return (int) $this->getProperty('userid');
    }

    public function getPublished(): \DateTimeInterface
    {
        return $this->getDateTime('published');
    }

    public function getUpdated(): \DateTimeInterface
    {
        return $this->getDateTime('updated');
    }

    public function isEditorial(): bool
    {
        return (bool) $this->getProperty('iseditorial');
    }

    public function getType(): string
    {
        return (string) $this->getProperty('itype');
    }

    public function getThumbnail(): string
    {
        return (string) $this->getProperty('thumbnail');
    }

    public function getMediumThumbnail(): string
    {
        return (string) $this->getProperty('medium_thumbnail');
    }

    public function getLargeThumbnail(): string
    {
        return (string) $this->getProperty('large_thumb');
    }

    public function getHugeThumbnail(): string
    {
        return (string) $this->getProperty('huge_thumb');
    }

    public function getUrl(): string
    {
        return (string) $this->getProperty('url');
    }

    public function getUrl2(): string
    {
        return (string) $this->getProperty('url2');
    }

    public function getBigUrl(): string
    {
        return (string) $this->getProperty('url_big');
    }

    public function getMaxQaUrl(): string
    {
        return (string) $this->getProperty('url_max_qa');
    }

    public function getItemUrl(): string
    {
        return (string) $this->getProperty('itemurl');
    }

    public function isFreeItem(): bool
    {
        return (bool) $this->getProperty('isFreeItem');
    }
}
