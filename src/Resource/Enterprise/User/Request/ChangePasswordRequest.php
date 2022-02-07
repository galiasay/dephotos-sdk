<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\User\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class ChangePasswordRequest implements RequestInterface
{
    private const COMMAND_NAME = 'changePasswordEnterpriseUserByAdmin';

    /** @var string */
    private $sessionId;

    /** @var string */
    private $newPassword;

    public function __construct(string $sessionId, string $newPassword)
    {
        $this->sessionId = $sessionId;
        $this->newPassword = $newPassword;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_session_id' => $this->getSessionId(),
            'dp_new_password' => $this->getNewPassword(),
        ];
    }
}
