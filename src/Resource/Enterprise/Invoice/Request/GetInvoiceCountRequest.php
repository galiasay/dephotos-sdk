<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\Invoice\Request;

use Depositphotos\SDK\Resource\RequestInterface;

class GetInvoiceCountRequest implements RequestInterface
{
    private const COMMAND_NAME = 'getEnterpriseInvoiceCount';

    /** @var string */
    private $sessionId;

    /** @var null|string */
    private $state;

    /** @var null|int */
    private $groupId;

    public function __construct(string $sessionId, ?string $state = null, ?int $groupId = null)
    {
        $this->sessionId = $sessionId;
        $this->state = $state;
        $this->groupId = $groupId;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_session_id' => $this->getSessionId(),
            'dp_state' => $this->getState(),
            'dp_group_id' => $this->getGroupId(),
        ];
    }
}
