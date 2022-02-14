<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enterprise\Purchase\Request;

use Depositphotos\SDK\Resource\RequestInterface;
use DateTimeInterface;

class GetChangedItemTransactionsRequest implements RequestInterface
{
    private const COMMAND_NAME = 'getChangedItemTransactions';

    /** @var string */
    private $sessionId;

    /** @var DateTimeInterface */
    private $fromDate;

    /** @var DateTimeInterface */
    private $toDate;

    /** @var null|string */
    private $status;

    public function __construct(
        string $sessionId,
        DateTimeInterface $fromDate,
        DateTimeInterface $toDate,
        ?string $status = null
    ) {
        $this->sessionId = $sessionId;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->status = $status;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getFromDate(): DateTimeInterface
    {
        return $this->fromDate;
    }

    public function getToDate(): DateTimeInterface
    {
        return $this->toDate;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function toArray(): array
    {
        return [
            'dp_command' => self::COMMAND_NAME,
            'dp_session_id' => $this->getSessionId(),
            'dp_date_from' => $this->getFromDate()->format('Y-m-d H:i:s'),
            'dp_date_to' => $this->getToDate()->format('Y-m-d H:i:s'),
            'dp_current_status' => $this->getStatus(),
        ];
    }
}
