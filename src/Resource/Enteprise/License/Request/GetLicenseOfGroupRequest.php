<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enteprise\License\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class GetLicenseOfGroupRequest implements RequestInterface
{
    private const COMMAND_NAME = 'getLicenseOfGroup';

    /** @var string */
    private $sessionId;

    public function __construct(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_session_id' => $this->getSessionId(),
        ];
    }
}
