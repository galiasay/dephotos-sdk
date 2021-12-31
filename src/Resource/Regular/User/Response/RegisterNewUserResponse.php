<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\User\Response;

class RegisterNewUserResponse
{
    /** @var int */
    private $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public static function create(array $data): self
    {
        return new self((int) ($data['userid'] ?? ''));
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
