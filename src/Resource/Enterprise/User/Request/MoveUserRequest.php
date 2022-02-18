<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\User\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class MoveUserRequest implements RequestInterface
{
    private const COMMAND_NAME = 'moveEnterpriseUser';

    /** @var string */
    private $sessionId;

    /** @var int */
    private $userId;

    /** @var int */
    private $groupId;

    public function __construct(string $sessionId, int $userId, int $groupId)
    {
        $this->sessionId = $sessionId;
        $this->userId = $userId;
        $this->groupId = $groupId;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getGroupId(): int
    {
        return $this->groupId;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_session_id' => $this->getSessionId(),
            'dp_user_id' => $this->getUserId(),
            'dp_group_id' => $this->getGroupId(),
        ];
    }
}
