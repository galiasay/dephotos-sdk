<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\User\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class GetStructureRequest implements RequestInterface
{
    private const COMMAND_NAME = 'getUserEnterpriseStructure';

    /** @var string */
    private $sessionId;

    /** @var bool */
    private $allStructure;

    public function __construct(string $sessionId, bool $allStructure = false)
    {
        $this->sessionId = $sessionId;
        $this->allStructure = $allStructure;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function isAllStructure(): bool
    {
        return $this->allStructure;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_session_id' => $this->getSessionId(),
            'dp_all_structure' => $this->isAllStructure(),
        ];
    }
}
