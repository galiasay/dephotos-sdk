<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\User\Response;

class RenewSessionResponse
{
    /** @var string */
    private $sessionId;

    /** @var string */
    private $sessionCookie;

    /** @var int */
    private $userId;

    public function __construct(string $sessionId, string $sessionCookie, int $userId)
    {
        $this->sessionId = $sessionId;
        $this->sessionCookie = $sessionCookie;
        $this->userId = $userId;
    }

    public static function create(array $data): self
    {
        return new self(
            (string) ($data['data']['sessionid'] ?? ''),
            (string) ($data['data']['session_cookie'] ?? ''),
            (int) ($data['data']['userid'] ?? 0)
        );
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getSessionCookie(): string
    {
        return $this->sessionCookie;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
