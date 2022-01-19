<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Resource\Regular\User\Response;

use Depositphotos\SDK\Resource\Regular\User\Response\GetUserData\Subscription;
use Depositphotos\SDK\Resource\ResponseObject;

class GetUserDataResponse extends ResponseObject
{
    public function getUsername(): string
    {
        return (string) $this->getProperty('username');
    }

    public function getBalance(): float
    {
        return (float) $this->getProperty('balance');
    }

    public function getStatus(): string
    {
        return (string) $this->getProperty('status');
    }

    public function getTimezone(): string
    {
        return (string) $this->getProperty('timezone');
    }

    public function getCreatedAt(): string
    {
        return (string) $this->getProperty('createdAt');
    }

    public function getCountry(): string
    {
        return (string) $this->getProperty('country');
    }

    public function getState(): string
    {
        return (string) $this->getProperty('state');
    }

    public function getCity(): string
    {
        return (string) $this->getProperty('city');
    }

    public function getAddress(): string
    {
        return (string) $this->getProperty('address');
    }

    public function getZip(): string
    {
        return (string) $this->getProperty('zip');
    }

    public function getEmail(): string
    {
        return (string) $this->getProperty('email');
    }

    public function getFirstName(): string
    {
        return (string) $this->getProperty('firstName');
    }

    public function getLastName(): string
    {
        return (string) $this->getProperty('lastName');
    }

    public function getGender(): string
    {
        return (string) $this->getProperty('gender');
    }

    public function getPhone(): string
    {
        return (string) $this->getProperty('phone');
    }

    public function getFacebook(): string
    {
        return (string) $this->getProperty('facebook');
    }

    public function getNews(): string
    {
        return (string) $this->getProperty('news');
    }

    public function getBusinessName(): string
    {
        return (string) $this->getProperty('businessName');
    }

    public function getCompany(): string
    {
        return (string) $this->getProperty('company');
    }

    public function getAvatar(): string
    {
        return (string) $this->getProperty('avatar');
    }

    public function getWebsite(): ?string
    {
        $website = $this->getProperty('website');

        return $website !== null ? (string) $website : null;
    }

    public function getBiography(): ?string
    {
        $biography = $this->getProperty('biography');

        return $biography !== null ? (string) $biography : null;
    }

    public function getBusinessPhone(): ?string
    {
        $businessPhone = $this->getProperty('businessPhone');

        return $businessPhone !== null ? (string) $businessPhone : null;
    }

    public function getCreditsAmount(): ?float
    {
        $creditsAmount = $this->getProperty('creditsAmount');

        return $creditsAmount !== null ? (float) $creditsAmount : null;
    }

    public function getFilesAmount(): ?int
    {
        $filesAmount = $this->getProperty('filesAmount');

        return $filesAmount !== null ? (int) $filesAmount : null;
    }

    public function getInvoiceAmount(): ?int
    {
        $invoiceAmount = $this->getProperty('invoiceAmount');

        return $invoiceAmount !== null ? (int) $invoiceAmount : null;
    }

    public function getOccupation(): ?string
    {
        $occupation = $this->getProperty('occupation');

        return $occupation !== null ? (string) $occupation : null;
    }

    public function getVatNumber(): ?string
    {
        $vatNumber = $this->getProperty('vatNumber');

        return $vatNumber !== null ? (string) $vatNumber : null;
    }

    public function getIndustry(): ?string
    {
        $industry = $this->getProperty('industry');

        return $industry !== null ? (string) $industry : null;
    }

    public function getEquipment(): ?string
    {
        $equipment = $this->getProperty('equipment');

        return $equipment !== null ? (string) $equipment : null;
    }

    public function getNotifySales(): ?string
    {
        $notifySales = $this->getProperty('notifySales');

        return $notifySales !== null ? (string) $notifySales : null;
    }

    public function getNotifySelection(): ?string
    {
        $notifySelection = $this->getProperty('notifySelection');

        return $notifySelection !== null ? (string) $notifySelection : null;
    }

    /**
     * @return Subscription[]
     */
    public function getSubscriptions(): array
    {
        return (array) $this->getProperty('subscriptions', Subscription::class);
    }
}
