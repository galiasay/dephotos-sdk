<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\User\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class ChangeEmailRequest implements RequestInterface
{
    private const COMMAND_NAME = 'changeEmail';

    /** @var string */
    private $sessionId;

    /** @var string */
    private $email;

    public function __construct(string $sessionId, string $email)
    {
        $this->sessionId = $sessionId;
        $this->email = $email;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_session_id' => $this->getSessionId(),
            'dp_email' => $this->getEmail(),
        ];
    }
}
