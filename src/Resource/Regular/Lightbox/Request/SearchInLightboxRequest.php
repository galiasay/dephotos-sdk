<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\Lightbox\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class SearchInLightboxRequest implements RequestInterface
{
    private const COMMAND_NAME = 'searchInLightbox';

    /** @var int */
    private $lightboxId;

    /** @var int */
    private $limit;

    /** @var int */
    private $offset;

    /** @var null|string */
    private $query;

    /** @var null|string */
    private $hash;

    /** @var null|bool */
    private $searchPhoto;

    /** @var null|bool */
    private $searchVector;

    /** @var null|bool */
    private $searchVideo;

    /** @var null|bool */
    private $searchAudio;

    /** @var null|bool */
    private $searchEditorial;

    public function __construct(int $lightboxId, int $limit, int $offset, ?string $query = null, ?string $hash = null)
    {
        $this->lightboxId = $lightboxId;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->query = $query;
        $this->hash = $hash;
    }

    public function getLightboxId(): int
    {
        return $this->lightboxId;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function getSearchPhoto(): ?bool
    {
        return $this->searchPhoto;
    }

    public function setSearchPhoto(?bool $searchPhoto): void
    {
        $this->searchPhoto = $searchPhoto;
    }

    public function getSearchVector(): ?bool
    {
        return $this->searchVector;
    }

    public function setSearchVector(?bool $searchVector): void
    {
        $this->searchVector = $searchVector;
    }

    public function getSearchVideo(): ?bool
    {
        return $this->searchVideo;
    }

    public function setSearchVideo(?bool $searchVideo): void
    {
        $this->searchVideo = $searchVideo;
    }

    public function getSearchAudio(): ?bool
    {
        return $this->searchAudio;
    }

    public function setSearchAudio(?bool $searchAudio): void
    {
        $this->searchAudio = $searchAudio;
    }

    public function getSearchEditorial(): ?bool
    {
        return $this->searchEditorial;
    }

    public function setSearchEditorial(?bool $searchEditorial): void
    {
        $this->searchEditorial = $searchEditorial;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_limit' => $this->getLimit(),
            'dp_offset' => $this->getOffset(),
            'dp_lightbox_id' => $this->getLightboxId(),
            'dp_query' => $this->getQuery(),
            'dp_search_hash' => $this->getHash(),
            'dp_search_photo' => $this->getSearchPhoto(),
            'dp_search_vector' => $this->getSearchVector(),
            'dp_search_video' => $this->getSearchVideo(),
            'dp_search_audio' => $this->getSearchAudio(),
            'dp_search_editorial' => $this->getSearchEditorial(),
        ];
    }
}
