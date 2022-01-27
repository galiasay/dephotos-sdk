<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\Purchase\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class GetMediaRequest implements RequestInterface
{
    private const COMMAND_NAME = 'getMedia';

    /** @var string */
    private $sessionId;

    /** @var int */
    private $mediaId;

    /** @var string */
    private $mediaOption;

    /** @var string */
    private $mediaLicense;

    /** @var null|int */
    private $subscriptionId;

    public function __construct(
        string $sessionId,
        int $mediaId,
        string $mediaOption,
        string $mediaLicense,
        ?int $subscriptionId = null
    ) {
        $this->sessionId = $sessionId;
        $this->mediaId = $mediaId;
        $this->mediaOption = $mediaOption;
        $this->mediaLicense = $mediaLicense;
        $this->subscriptionId = $subscriptionId;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getMediaId(): int
    {
        return $this->mediaId;
    }

    public function getMediaOption(): string
    {
        return $this->mediaOption;
    }

    public function getMediaLicense(): string
    {
        return $this->mediaLicense;
    }

    public function getSubscriptionId(): ?int
    {
        return $this->subscriptionId;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_session_id' => $this->getSessionId(),
            'dp_media_id' => $this->getMediaId(),
            'dp_media_option' => $this->getMediaOption(),
            'dp_media_license' => $this->getMediaLicense(),
            'dp_subscription_id' => $this->getSubscriptionId(),
        ];
    }
}
