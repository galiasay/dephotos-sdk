<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\User\Response;

use Depositphotos\SDK\Resource\ResponseObject;

class RenewSessionResponse extends ResponseObject
{
    public function getSessionId(): string
    {
        return (string) $this->getProperty('sessionid');
    }

    public function getSessionCookie(): string
    {
        return (string) $this->getProperty('session_cookie');
    }

    public function getUserId(): int
    {
        return (int) $this->getProperty('userid');
    }
}
