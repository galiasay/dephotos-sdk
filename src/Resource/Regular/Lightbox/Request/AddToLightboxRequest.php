<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\Lightbox\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class AddToLightboxRequest implements RequestInterface
{
    private const COMMAND_NAME = 'addToLightbox';

    /** @var string */
    private $sessionId;

    /** @var int */
    private $lightboxId;

    /** @var array */
    private $mediaIds;

    public function __construct(string $sessionId, int $lightboxId, array $mediaIds)
    {
        $this->sessionId = $sessionId;
        $this->lightboxId = $lightboxId;
        $this->mediaIds = $mediaIds;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getLightboxId(): int
    {
        return $this->lightboxId;
    }

    public function getMediaIds(): array
    {
        return $this->mediaIds;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_session_id' => $this->getSessionId(),
            'dp_lightbox_id' => $this->getLightboxId(),
            'dp_media_id' => $this->getMediaIds(),
        ];
    }
}
