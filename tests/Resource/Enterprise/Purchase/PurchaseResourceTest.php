<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Enterprise\Purchase;

use Depositphotos\SDK\Resource\Enterprise\Purchase\PurchaseResource;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\GetDownloadUrlRequest;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\GetLicensedItemsRequest;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\LicenseItem\LicensingInfo;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\LicenseItemRequest;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Response\LicenseItem\Success;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Response\LicenseItem\Error;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Response\GetLicensedItems\User;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class PurchaseResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testGetDownloadUrl(): void
    {
        $requestData = [
            'dp_command' => 'getDownloadLink',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_item_id' => 123,
            'dp_option' => 'l',
        ];

        $responseData = [
            'type' => 'success',
            'downloadLink' => 'https://download....81097b25',
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getDownloadUrl(new GetDownloadUrlRequest(
            $requestData['dp_session_id'],
            $requestData['dp_item_id'],
            $requestData['dp_option']
        ));

        $this->assertEquals($responseData['downloadLink'], $result->getDownloadUrl());
    }

    public function testLicenseItem(): void
    {
        $requestData = [
            'dp_command' => 'licenseItem',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_licensing' => [
                [
                    'dp_item_id' => [12345678, 12345679],
                    'dp_option' => 'l',
                    'dp_license_id' => 12453,
                ],
            ],
            'dp_project' => 'Project',
            'dp_client' => 'Client',
            'dp_purchase_order' => null,
            'dp_isbn' => 'isbn',
            'dp_other' => null,
        ];

        $responseData = [
            'type' => 'success',
            'result' => [
                12345678 => [
                    'result' => 'success',
                    'transaction' => [
                        [
                            'transactionId' => 1234567,
                            'license' => 10123,
                            'sizes' => 2,
                        ]
                    ],
                    'fileId' => 12345678,
                    'downloadLink' => 'http://st.depositphotos.com/storage/item/download?id=1234'
                ],
                12345679 => [
                    'result' => 'error',
                    'errors' => [
                        [
                            'error_message' => 'message',
                            'error_code' => 100,
                        ],
                    ]
                ]
            ],
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $request = new LicenseItemRequest(
            $requestData['dp_session_id'],
            [new LicensingInfo(
                $requestData['dp_licensing'][0]['dp_item_id'],
                $requestData['dp_licensing'][0]['dp_option'],
                $requestData['dp_licensing'][0]['dp_license_id']
            )]
        );
        $request
            ->setProject($requestData['dp_project'])
            ->setClient($requestData['dp_client'])
            ->setPurchaseOrder($requestData['dp_purchase_order'])
            ->setIsbn($requestData['dp_isbn'])
            ->setOther($requestData['dp_other']);
        $result = $resource->licenseItem($request);

        /** @var Success $successResult */
        $successResult = $result->getResult()[0];
        $successExpected = $responseData['result'][12345678];
        $this->assertInstanceOf(Success::class, $successResult);
        $this->assertEquals($successExpected['fileId'], $successResult->getItemId());
        $this->assertEquals($successExpected['downloadLink'], $successResult->getDownloadUrl());
        $this->assertEquals($successExpected['transaction'][0]['transactionId'], $successResult->getTransactions()[0]->getId());
        $this->assertEquals($successExpected['transaction'][0]['license'], $successResult->getTransactions()[0]->getLicenseId());
        $this->assertEquals($successExpected['transaction'][0]['sizes'], $successResult->getTransactions()[0]->getSizes());

        /** @var Error $errorResult */
        $errorResult = $result->getResult()[1];
        $errorExpected = $responseData['result'][12345679]['errors'][0];
        $this->assertInstanceOf(Error::class, $errorResult);
        $this->assertEquals(12345679, $errorResult->getItemId());
        $this->assertEquals($errorExpected['error_message'], $errorResult->getMessage());
        $this->assertEquals($errorExpected['error_code'], $errorResult->getCode());
    }

    public function testGetLicensedItems(): void
    {
        $requestData = [
            'dp_command' => 'getLicensedItems',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_limit' => 10,
            'dp_offset' => 0,
            'dp_type' => 'paid',
            'dp_user_id' => null,
            'dp_group_id' => null,
            'dp_date_start' => '2022-01-01 00:00:00',
            'dp_date_end' => '2022-01-31 23:59:59',
        ];

        $responseData = [
            'type' => 'success',
            'downloads' => [
                [
                    'itemTransactionId' => 324234,
                    'licenseTransferId' => 123112,
                    'licenseId' => 43132,
                    'status' => 'active',
                    'currencyId' => 0,
                    'datetime' => 1471871234,
                    'filename' => 'File name here',
                    'groupId' => 12,
                    'itemId' => 12345678,
                    'marker' => 3,
                    'itemType' => 'video',
                    'preview' => 'http://st.depositphotos.com/123/linktofile/filename.jpg',
                    'width' => 1920,
                    'height' => 1080,
                    'userId' => 12345678,
                    'actor' => [
                        'id' => 12345678,
                        'username' => 'Usertest',
                    ],
                    'seller' => [
                        'id' => 12345678,
                        'username' => 'Usertest',
                    ],
                    'editorial' => false,
                    'visible' => true,
                    'invoice_id' => 2126132,
                    'project' => 'Project',
                    'purchaseOrder' => 'Purchase Order',
                    'client' => 'Client',
                    'isbn' => 'Isbn',
                    'other' => 'Other'
                ],
            ],
            'count' => 1
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getLicensedItems(new GetLicensedItemsRequest(
            $requestData['dp_session_id'],
            $requestData['dp_limit'],
            $requestData['dp_offset'],
            $requestData['dp_type'],
            $requestData['dp_user_id'],
            $requestData['dp_group_id'],
            new \DateTime($requestData['dp_date_start']),
            new \DateTime($requestData['dp_date_end'])
        ));

        $this->assertEquals($responseData['count'], $result->getCount());

        foreach ($result->getItems() as $key => $item) {
            $this->assertEquals($responseData['downloads'][$key]['itemTransactionId'], $item->getTransaction()->getId());
            $this->assertEquals($responseData['downloads'][$key]['licenseTransferId'], $item->getTransaction()->getLicenseTransferId());
            $this->assertEquals($responseData['downloads'][$key]['licenseId'], $item->getTransaction()->getLicenseId());
            $this->assertEquals($responseData['downloads'][$key]['status'], $item->getTransaction()->getStatus());
            $this->assertEquals($responseData['downloads'][$key]['currencyId'], $item->getTransaction()->getCurrencyId());
            $this->assertEquals($responseData['downloads'][$key]['datetime'], $item->getTransaction()->getCreated()->getTimestamp());
            $this->assertEquals($responseData['downloads'][$key]['filename'], $item->getFileName());
            $this->assertEquals($responseData['downloads'][$key]['groupId'], $item->getTransaction()->getGroupId());
            $this->assertEquals($responseData['downloads'][$key]['itemId'], $item->getId());
            $this->assertEquals($responseData['downloads'][$key]['marker'], $item->getTransaction()->getMarker());
            $this->assertEquals($responseData['downloads'][$key]['itemType'], $item->getType());
            $this->assertEquals($responseData['downloads'][$key]['preview'], $item->getPreview());
            $this->assertEquals($responseData['downloads'][$key]['width'], $item->getWidth());
            $this->assertEquals($responseData['downloads'][$key]['height'], $item->getHeight());
            $this->assertEquals($responseData['downloads'][$key]['userId'], $item->getTransaction()->getUserId());
            $this->assertUser($responseData['downloads'][$key]['actor'], $item->getTransaction()->getActor());
            $this->assertUser($responseData['downloads'][$key]['seller'], $item->getTransaction()->getSeller());
            $this->assertEquals($responseData['downloads'][$key]['editorial'], $item->isEditorial());
            $this->assertEquals($responseData['downloads'][$key]['visible'], $item->isVisible());
            $this->assertEquals($responseData['downloads'][$key]['invoice_id'], $item->getTransaction()->getInvoiceId());
            $this->assertEquals($responseData['downloads'][$key]['project'], $item->getTransaction()->getProject());
            $this->assertEquals($responseData['downloads'][$key]['purchaseOrder'], $item->getTransaction()->getPurchaseOrder());
            $this->assertEquals($responseData['downloads'][$key]['client'], $item->getTransaction()->getClient());
            $this->assertEquals($responseData['downloads'][$key]['isbn'], $item->getTransaction()->getIsbn());
            $this->assertEquals($responseData['downloads'][$key]['other'], $item->getTransaction()->getOther());
        }
    }

    private function assertUser(array $expected, User $user): void
    {
        $this->assertEquals($expected['id'], $user->getId());
        $this->assertEquals($expected['username'], $user->getUsername());
    }
}
