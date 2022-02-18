<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enteprise\License;

use Depositphotos\SDK\Resource\Enteprise\License\Request\GetLicenseOfGroupRequest;
use Depositphotos\SDK\Resource\Enteprise\License\Request\GetTransactionLicenseInfoRequest;
use Depositphotos\SDK\Resource\Enteprise\License\Request\GetTransferredLicensesRequest;
use Depositphotos\SDK\Resource\Enteprise\License\Request\TransferLicenseRequest;
use Depositphotos\SDK\Resource\Enteprise\License\Response\GetLicenseOfGroupResponse;
use Depositphotos\SDK\Resource\Enteprise\License\Response\GetTransactionLicenseInfoResponse;
use Depositphotos\SDK\Resource\Enteprise\License\Response\GetTransferredLicensesResponse;
use Depositphotos\SDK\Resource\Resource;

class LicenseResource extends Resource
{
    public function getLicenseOfGroup(GetLicenseOfGroupRequest $request): GetLicenseOfGroupResponse
    {
        $httpResponse = $this->send($request);

        return new GetLicenseOfGroupResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function getTransactionLicenseInfo(GetTransactionLicenseInfoRequest $request): GetTransactionLicenseInfoResponse
    {
        $httpResponse = $this->send($request);

        return new GetTransactionLicenseInfoResponse($this->convertHttpResponseToArray($httpResponse));
    }

    public function transferLicense(TransferLicenseRequest $request): void
    {
        $this->send($request);
    }

    public function getTransferredLicenses(GetTransferredLicensesRequest $request): GetTransferredLicensesResponse
    {
        $httpResponse = $this->send($request);

        return new GetTransferredLicensesResponse($this->convertHttpResponseToArray($httpResponse));
    }
}
