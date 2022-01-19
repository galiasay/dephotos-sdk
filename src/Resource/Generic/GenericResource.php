<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Generic;

use Depositphotos\SDK\Resource\Generic\Request\GetInfoRequest;
use Depositphotos\SDK\Resource\Generic\Request\HelpRequest;
use Depositphotos\SDK\Resource\Generic\Response\GetInfoResponse;
use Depositphotos\SDK\Resource\Generic\Response\HelpResponse;
use Depositphotos\SDK\Resource\Resource;

class GenericResource extends Resource
{
    public function getInfo(GetInfoRequest $request): GetInfoResponse
    {
        $httpResponse = $this->send($request);

        return GetInfoResponse::create($this->convertHttpResponseToArray($httpResponse));
    }

    public function help(HelpRequest $request): HelpResponse
    {
        $httpResponse = $this->send($request);

        return HelpResponse::create($this->convertHttpResponseToArray($httpResponse));
    }
}
