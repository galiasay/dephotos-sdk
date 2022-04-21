<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Corporate\SubAccount;

use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\CreateSubAccountRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\CreateSubAccountSubscriptionRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\DeleteSubAccountRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\GetCreditStatusRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\GetSubAccountDataRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\GetSubAccountPurchasesRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\GetSubAccountsRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\GetSubscriptionOffersRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\GetSubscriptionsRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Request\UpdateSubAccountRequest;
use Depositphotos\SDK\Resource\Corporate\SubAccount\Response\Common\Subscription;
use Depositphotos\SDK\Resource\Corporate\SubAccount\SubAccountResource;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class SubAccountResourceTest extends BaseTestCase
{
    use ResourceTrait;

    private const DATE_FORMAT = 'M.d, Y H:i:s';

    public function testCreateSubAccount(): void
    {
        $requestData = [
            'dp_command' => 'createSubaccount',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_email' => 'subaccount@email.com',
            'dp_subaccount_fname' => 'FirstName',
            'dp_subaccount_lname' => 'LastName',
            'dp_subaccount_username' => null,
            'dp_subaccount_password' => null,
        ];

        $responseData = [
            'type' => 'success',
            'subaccountId' => 123,
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->createSubAccount(new CreateSubAccountRequest(
            $requestData['dp_session_id'],
            $requestData['dp_subaccount_email'],
            $requestData['dp_subaccount_fname'],
            $requestData['dp_subaccount_lname'],
            $requestData['dp_subaccount_username'],
            $requestData['dp_subaccount_password']
        ));

        $this->assertEquals($responseData['subaccountId'], $result->getSubAccountId());
    }

    public function testUpdateSubAccount(): void
    {
        $requestData = [
            'dp_command' => 'updateSubaccount',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_id' => 123,
            'dp_subaccount_email' => 'subaccount@email.com',
            'dp_subaccount_fname' => 'FirstName',
            'dp_subaccount_lname' => 'LastName',
            'dp_subaccount_company' => null,
        ];

        $responseData = [
            'type' => 'success',
            'subaccountId' => 123,
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));
        $request = new UpdateSubAccountRequest($requestData['dp_session_id'], $requestData['dp_subaccount_id']);
        $request
            ->setFirstName($requestData['dp_subaccount_fname'])
            ->setLastName($requestData['dp_subaccount_lname'])
            ->setEmail($requestData['dp_subaccount_email'])
            ->setCompany($requestData['dp_subaccount_company']);

        $result = $resource->updateSubAccount($request);

        $this->assertEquals($responseData['subaccountId'], $result->getSubAccountId());
    }

    public function testCreateSubAccountSubscription(): void
    {
        $requestData = [
            'dp_command' => 'createSubaccountSubscription',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_id' => 123,
            'dp_offer_id' => 1,
        ];

        $responseData = [
            'type' => 'success',
            'product_id' => 123,
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->createSubAccountSubscription(new CreateSubAccountSubscriptionRequest(
            $requestData['dp_session_id'],
            $requestData['dp_subaccount_id'],
            $requestData['dp_offer_id']
        ));

        $this->assertEquals($responseData['product_id'], $result->getProductId());
    }

    public function testDeleteSubAccount(): void
    {
        $requestData = [
            'dp_command' => 'deleteSubaccount',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_id' => 123,
        ];

        $responseData = [
            'type' => 'success',
            'subaccountId' => 123,
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));

        $result = $resource->deleteSubAccount(new DeleteSubAccountRequest(
            $requestData['dp_session_id'],
            $requestData['dp_subaccount_id']
        ));

        $this->assertEquals($responseData['subaccountId'], $result->getSubAccountId());
    }

    public function testGetCreditStatus(): void
    {
        $requestData = [
            'dp_command' => 'getCreditStatus',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_id' => 123,
        ];

        $responseData = [
            'type' => 'success',
            'creditsAmount' => 100.50,
            'subscriptionAmount' => 25,
            'invoiceAmount' => 3,
            'filesAmount' => 5,
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));

        $result = $resource->getCreditStatus(new GetCreditStatusRequest(
            $requestData['dp_session_id'],
            $requestData['dp_subaccount_id']
        ));

        $this->assertEquals($responseData['creditsAmount'], $result->getCreditsAmount());
        $this->assertEquals($responseData['subscriptionAmount'], $result->getSubscriptionAmount());
        $this->assertEquals($responseData['invoiceAmount'], $result->getInvoiceAmount());
        $this->assertEquals($responseData['filesAmount'], $result->getFilesAmount());
    }

    public function testGetSubAccountData(): void
    {
        $requestData = [
            'dp_command' => 'getSubaccountData',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_id' => 123,
            'dp_datetime_format' => null,
        ];

        $responseData = [
            'type' => 'success',
            'creditsAmount' => 100.50,
            'subscriptionAmount' => 25,
            'invoiceAmount' => 3,
            'filesAmount' => 5,
            'subscriptions' => [
                [
                    'id' => '7928098',
                    'name' => 'Promo Subscription',
                    'status' => 'active',
                    'price' => 99.99,
                    'purchaseMethod' => 'promocode',
                    'dateBegin' => 'Sep.02, 2014 13:15:00',
                    'dateEnd' => 'Sep.17, 2015 13:15:00',
                    'amount' => 5,
                    'period' => 30,
                    'buyPeriod' => 1,
                    'renewalTime' => 'Sep.17, 2015 13:15:00',
                    'membership' => false,
                ],
            ],
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));

        $result = $resource->getSubAccountData(new GetSubAccountDataRequest(
            $requestData['dp_session_id'],
            $requestData['dp_subaccount_id']
        ));

        $this->assertEquals($responseData['creditsAmount'], $result->getCreditsAmount());
        $this->assertEquals($responseData['subscriptionAmount'], $result->getSubscriptionAmount());
        $this->assertEquals($responseData['invoiceAmount'], $result->getInvoiceAmountO());
        $this->assertEquals($responseData['filesAmount'], $result->getFilesAmount());

        foreach ($result->getSubscriptions() as $key => $subscription) {
            $this->assertSubscription($responseData['subscriptions'][$key], $subscription);
        }
    }

    public function testGetSubAccountPurchases(): void
    {
        $requestData = [
            'dp_command' => 'getSubaccountPurchases',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_id' => 123,
            'dp_subaccount_limit' => 1,
            'dp_subaccount_offset' => 0,
            'dp_datetime_format' => null,
        ];

        $responseData = [
            'type' => 'success',
            'purchases' => [
                [
                    'mediaId' => '20162175',
                    'license' => 'standard',
                    'size' => 'm',
                    'price' => '1.00',
                    'purchaseDate' => 'Apr.18, 2013 14:54:25',
                    'url' => 'http://st.depositphotos.c...Verona-Italy.jpg',
                    'licenseId' => '8988231',
                    'width' => '3456',
                    'height' => '5184',
                    'mp' => '17.92',
                ],
            ],
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));

        $result = $resource->getSubAccountPurchases(new GetSubAccountPurchasesRequest(
            $requestData['dp_session_id'],
            $requestData['dp_subaccount_id'],
            $requestData['dp_subaccount_limit'],
            $requestData['dp_subaccount_offset'],
            $requestData['dp_datetime_format']
        ));

        foreach ($result->getPurchases() as $key => $purchase) {
            $this->assertEquals($responseData['purchases'][$key]['mediaId'], $purchase->getItemId());
            $this->assertEquals($responseData['purchases'][$key]['license'], $purchase->getLicense());
            $this->assertEquals($responseData['purchases'][$key]['size'], $purchase->getSize());
            $this->assertEquals($responseData['purchases'][$key]['price'], $purchase->getPrice());
            $this->assertEquals($responseData['purchases'][$key]['purchaseDate'], $purchase->getPurchaseDate()->format(self::DATE_FORMAT));
            $this->assertEquals($responseData['purchases'][$key]['url'], $purchase->getUrl());
            $this->assertEquals($responseData['purchases'][$key]['licenseId'], $purchase->getLicenseId());
            $this->assertEquals($responseData['purchases'][$key]['width'], $purchase->getWidth());
            $this->assertEquals($responseData['purchases'][$key]['height'], $purchase->getHeight());
            $this->assertEquals($responseData['purchases'][$key]['mp'], $purchase->getMp());
        }
    }

    public function testGetSubAccounts(): void
    {
        $requestData = [
            'dp_command' => 'getSubaccounts',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_limit' => 3,
            'dp_subaccount_offset' => 0,
        ];

        $responseData = [
            'type' => 'success',
            'subaccounts' => [
                2179431,
                2179441,
                2186471
            ],
            'count' => 3,
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));

        $result = $resource->getSubAccounts(new GetSubAccountsRequest(
            $requestData['dp_session_id'],
            $requestData['dp_subaccount_limit'],
            $requestData['dp_subaccount_offset']
        ));

        $this->assertEquals($responseData['subaccounts'], $result->getSubAccounts());
        $this->assertEquals($responseData['count'], $result->getCount());
    }

    public function testGetSubscriptionOffers(): void
    {
        $requestData = [
            'dp_command' => 'getSubscriptionOffers',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_id' => 123,
        ];

        $responseData = [
            'type' => 'success',
            'offers' => [
                [
                    'offerId' => '31',
                    'name' => '1 month $69',
                    'description' => '5 images per day ($0.45 per image)',
                    'period' => '30',
                    'buyPeriod' => '1',
                    'count' => '5',
                    'price' => '69.00',
                    'discount' => '6.90',
                ],
            ],
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));

        $result = $resource->getSubscriptionOffers(new GetSubscriptionOffersRequest(
            $requestData['dp_session_id'],
            $requestData['dp_subaccount_id']
        ));

        foreach ($result->getOffers() as $key => $offer) {
            $this->assertEquals($responseData['offers'][$key]['offerId'], $offer->getId());
            $this->assertEquals($responseData['offers'][$key]['name'], $offer->getName());
            $this->assertEquals($responseData['offers'][$key]['description'], $offer->getDescription());
            $this->assertEquals($responseData['offers'][$key]['period'], $offer->getPeriod());
            $this->assertEquals($responseData['offers'][$key]['buyPeriod'], $offer->getBuyPeriod());
            $this->assertEquals($responseData['offers'][$key]['count'], $offer->getCount());
            $this->assertEquals($responseData['offers'][$key]['price'], $offer->getPrice());
            $this->assertEquals($responseData['offers'][$key]['discount'], $offer->getDiscount());
        }
    }

    public function testGetSubscriptions(): void
    {
        $requestData = [
            'dp_command' => 'getSubscriptions',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_subaccount_id' => 123,
            'dp_datetime_format' => null,
        ];

        $responseData = [
            'type' => 'success',
            'subscriptions' => [
                [
                    'id' => '7928098',
                    'name' => 'Promo Subscription',
                    'status' => 'active',
                    'price' => 99.99,
                    'purchaseMethod' => 'promocode',
                    'dateBegin' => 'Sep.02, 2014 13:15:00',
                    'dateEnd' => 'Sep.17, 2015 13:15:00',
                    'amount' => 5,
                    'period' => 30,
                    'buyPeriod' => 1,
                    'renewalTime' => 'Sep.17, 2015 13:15:00',
                    'membership' => false,
                ],
            ],
        ];

        $resource = new SubAccountResource($this->createHttpClient($requestData, $responseData));

        $result = $resource->getSubscriptions(new GetSubscriptionsRequest(
            $requestData['dp_session_id'],
            $requestData['dp_subaccount_id'],
            $requestData['dp_datetime_format']
        ));

        foreach ($result->getSubscriptions() as $key => $subscription) {
            $this->assertSubscription($responseData['subscriptions'][$key], $subscription);
        }
    }

    private function assertSubscription(array $expected, Subscription $subscription): void
    {
        $this->assertEquals($expected['id'], $subscription->getId());
        $this->assertEquals($expected['name'], $subscription->getName());
        $this->assertEquals($expected['status'], $subscription->getStatus());
        $this->assertEquals($expected['purchaseMethod'], $subscription->getPurchaseMethod());
        $this->assertEquals($expected['dateBegin'], $subscription->getBeginDate()->format(self::DATE_FORMAT));
        $this->assertEquals($expected['dateEnd'], $subscription->getEndDate()->format(self::DATE_FORMAT));
        $this->assertEquals($expected['amount'], $subscription->getAmount());
        $this->assertEquals($expected['period'], $subscription->getPeriod());
        $this->assertEquals($expected['buyPeriod'], $subscription->getBuyPeriod());
        $this->assertEquals($expected['renewalTime'], $subscription->getRenewalTime()->format(self::DATE_FORMAT));
        $this->assertEquals($expected['price'], $subscription->getPrice());
        $this->assertEquals($expected['membership'], $subscription->isMembership());
    }
}
