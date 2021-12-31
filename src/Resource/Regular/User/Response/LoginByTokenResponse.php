<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\User\Response;

class LoginByTokenResponse
{
    /** @var string */
    private $sessionId;

    public function __construct(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public static function create(array $data): self
    {
        return new self((string) ($data['sessionid'] ?? ''));
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }
}
