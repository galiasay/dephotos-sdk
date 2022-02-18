<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Enteprise\License\Response\GetTransactionLicenseInfo;

use Depositphotos\SDK\Resource\ResponseObject;

class LegalInfo extends ResponseObject
{
    public function getCompany(): string
    {
        return (string) $this->getProperty('company');
    }

    public function getFullName(): string
    {
        return (string) $this->getProperty('fullName');
    }

    public function getAddress(): string
    {
        return (string) $this->getProperty('address');
    }

    public function getCity(): string
    {
        return (string) $this->getProperty('city');
    }

    public function getState(): string
    {
        return (string) $this->getProperty('state');
    }

    public function getZip(): string
    {
        return (string) $this->getProperty('zip');
    }

    public function getEmail(): string
    {
        return (string) $this->getProperty('email');
    }

    public function getPhone(): string
    {
        return (string) $this->getProperty('phone');
    }

    public function getCountry(): string
    {
        return (string) $this->getProperty('country');
    }

    public function getWebsite(): ?string
    {
        return $this->getProperty('website');
    }

    public function getEin(): ?string
    {
        return $this->getProperty('ein');
    }

    public function getVat(): string
    {
        return (string) $this->getProperty('vat');
    }

    public function getTaxId(): string
    {
        return (string) $this->getProperty('taxId');
    }

    public function getCountryName(): ?string
    {
        return $this->getProperty('countryName');
    }
}
