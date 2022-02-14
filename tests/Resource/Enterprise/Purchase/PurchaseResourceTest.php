<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Enterprise\Purchase;

use Depositphotos\SDK\Resource\Enterprise\Purchase\PurchaseResource;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\ComplimentaryDownloadRequest;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\GetChangedItemTransactionsRequest;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\GetDownloadUrlRequest;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\GetGroupCompDownloadsRequest;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\LicenseItem\LicensingInfo;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Request\LicenseItemRequest;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Response\LicenseItem\Success;
use Depositphotos\SDK\Resource\Enterprise\Purchase\Response\LicenseItem\Error;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class PurchaseResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testComplimentaryDownload(): void
    {
        $requestData = [
            'dp_command' => 'complimentaryDownload',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_item_id' => 123,
            'dp_option' => 'l',
        ];

        $responseData = [
            'type' => 'success',
            'downloadLink' => 'https://download....81097b25',
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->complimentaryDownload(new ComplimentaryDownloadRequest(
            $requestData['dp_session_id'],
            $requestData['dp_item_id'],
            $requestData['dp_option']
        ));

        $this->assertEquals($responseData['downloadLink'], $result->getDownloadUrl());
    }

    public function testGetGroupCompDownloads(): void
    {
        $requestData = [
            'dp_command' => 'getGroupCompDownloads',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_limit' => 10,
            'dp_offset' => 0,
            'dp_type' => ['image'],
            'dp_user_id' => null,
            'dp_group_id' => null,
            'dp_date_start' => '2022-01-01 00:00:00',
            'dp_date_end' => '2022-01-31 23:59:59',
        ];

        $responseData = [
            'type' => 'success',
            'downloads' => [
               [
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
                   'download' => 'http://st.depositphotos.com/storage/item/download?id=1234',
                   'visible' => true,
               ],
           ],
            'count' => 100,
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getGroupCompDownloads(new GetGroupCompDownloadsRequest(
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
        foreach ($result->getDownloads() as $key => $download) {
            $this->assertEquals($responseData['downloads'][$key]['datetime'], $download->getUpdated()->getTimestamp());
            $this->assertEquals($responseData['downloads'][$key]['groupId'], $download->getGroupId());
            $this->assertEquals($responseData['downloads'][$key]['itemId'], $download->getItem()->getId());
            $this->assertEquals($responseData['downloads'][$key]['filename'], $download->getItem()->getFileName());
            $this->assertEquals($responseData['downloads'][$key]['marker'], $download->getMarker());
            $this->assertEquals($responseData['downloads'][$key]['itemType'], $download->getItem()->getType());
            $this->assertEquals($responseData['downloads'][$key]['preview'], $download->getItem()->getPreview());
            $this->assertEquals($responseData['downloads'][$key]['width'], $download->getItem()->getWidth());
            $this->assertEquals($responseData['downloads'][$key]['height'], $download->getItem()->getHeight());
            $this->assertEquals($responseData['downloads'][$key]['userId'], $download->getUserId());
            $this->assertEquals($responseData['downloads'][$key]['actor']['id'], $download->getActor()->getId());
            $this->assertEquals($responseData['downloads'][$key]['actor']['username'], $download->getActor()->getUsername());
            $this->assertEquals($responseData['downloads'][$key]['seller']['id'], $download->getSeller()->getId());
            $this->assertEquals($responseData['downloads'][$key]['seller']['username'], $download->getSeller()->getUsername());
            $this->assertEquals($responseData['downloads'][$key]['download'], $download->getDownloadUrl());
            $this->assertEquals($responseData['downloads'][$key]['visible'], $download->getItem()->isVisible());
        }
    }

    public function testGetChangedItemTransactions(): void
    {
        $requestData = [
            'dp_command' => 'getChangedItemTransactions',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_date_from' => '2022-01-01 00:00:00',
            'dp_date_to' => '2022-01-31 23:59:59',
            'dp_current_status' => null,
        ];

        $responseData = [
            'type' => 'success',
            'result' => [
                [
                    'item_transaction_id' => 74699552,
                    'status_from' => 'active',
                    'status_to' => 'cancelled',
                    'date_changed' => '2021-05-28 13:22:31',
                    'transaction_info' => [
                        'item_transaction_id' => 74699552,
                        'user_id' => 13692607,
                        'method' => 'es_license',
                        'option' => 's-2015',
                        'license' => 'enterprise',
                        'deposit_item_id' => 122795112,
                        'price' => 9,
                        'bonus_option' => '',
                        'timestamp' => '1612991135',
                        'status' => 'cancelled',
                        'subaccount_id' => 0,
                        'format' => 'raster',
                        'method_id' => 375497,
                    ],
                ],
            ],
        ];

        $resource = new PurchaseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getChangedItemTransactions(new GetChangedItemTransactionsRequest(
            $requestData['dp_session_id'],
            new \DateTime($requestData['dp_date_from']),
            new \DateTime($requestData['dp_date_to']),
            $requestData['dp_current_status']
        ));

        foreach ($result->getTransactions() as $key => $transaction) {
            $this->assertEquals($responseData['result'][$key]['item_transaction_id'], $transaction->getId());
            $this->assertEquals($responseData['result'][$key]['status_from'], $transaction->getFromStatus());
            $this->assertEquals($responseData['result'][$key]['status_to'], $transaction->getToStatus());
            $this->assertEquals($responseData['result'][$key]['date_changed'], $transaction->getChanged()->format('Y-m-d H:i:s'));

            $info = $transaction->getInfo();
            $this->assertEquals($responseData['result'][$key]['transaction_info']['item_transaction_id'], $info->getTransactionId());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['user_id'], $info->getUserId());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['method'], $info->getMethod());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['method_id'], $info->getMethodId());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['option'], $info->getSize());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['license'], $info->getLicense());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['deposit_item_id'], $info->getItemId());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['price'], $info->getPrice());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['bonus_option'], $info->getBonusSize());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['timestamp'], $info->getCreated()->getTimestamp());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['status'], $info->getStatus());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['subaccount_id'], $info->getSubAccountId());
            $this->assertEquals($responseData['result'][$key]['transaction_info']['format'], $info->getFormat());
        }
    }

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
}
