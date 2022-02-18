<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Enterprise\License;

use Depositphotos\SDK\Resource\Enteprise\License\LicenseResource;
use Depositphotos\SDK\Resource\Enteprise\License\Request\GetLicenseOfGroupRequest;
use Depositphotos\SDK\Resource\Enteprise\License\Request\GetTransactionLicenseInfoRequest;
use Depositphotos\SDK\Resource\Enteprise\License\Request\GetTransferredLicensesRequest;
use Depositphotos\SDK\Resource\Enteprise\License\Request\TransferLicenseRequest;
use Depositphotos\SDK\Resource\Enteprise\License\Response\GetTransactionLicenseInfo\LegalInfo;
use Depositphotos\SDK\Resource\Enteprise\License\Request\TransferEnterpriseLicense\LegalInfo as LegalInfoRequest;
use Depositphotos\SDK\Resource\Enteprise\License\Response\GetTransferredLicenses\User;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class LicenseResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testGetLicenseOfGroup(): void
    {
        $requestData = [
            'dp_command' => 'getLicenseOfGroup',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
        ];

        $responseData = [
            'type' => 'success',
            'data' => [
                [
                    'licenseID' => 377,
                    'licenseName' => 'Social Media License',
                    'productType' => 'image',
                    'sizes' => [
                        [
                            'id' => 's-2015',
                            'label' => 'Small',
                            'price' => 9,
                            'enabled' => true,
                            'order' => 5,
                            'netId' => 1,
                        ],
                    ],
                    'enabledSizesCount' => 6,
                    'templateId' => 1,
                ],
            ],
            'count' => 1,
        ];

        $resource = new LicenseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getLicenseOfGroup(new GetLicenseOfGroupRequest(
            $requestData['dp_session_id']
        ));

        $this->assertEquals($responseData['count'], $result->getCount());

        foreach ($result->getLicenses() as $key => $license) {
            $this->assertEquals($responseData['data'][$key]['licenseID'], $license->getId());
            $this->assertEquals($responseData['data'][$key]['licenseName'], $license->getName());
            $this->assertEquals($responseData['data'][$key]['productType'], $license->getProductType());
            $this->assertEquals($responseData['data'][$key]['enabledSizesCount'], $license->getEnabledSizesCount());

            foreach ($license->getSizes() as $sizeKey => $size) {
                $expectedSize = $responseData['data'][$key]['sizes'][$sizeKey];

                $this->assertEquals($expectedSize['id'], $size->getId());
                $this->assertEquals($expectedSize['label'], $size->getLabel());
                $this->assertEquals($expectedSize['price'], $size->getPrice());
                $this->assertEquals($expectedSize['enabled'], $size->isEnabled());
                $this->assertEquals($expectedSize['order'], $size->getOrder());
                $this->assertEquals($expectedSize['netId'], $size->getNetId());
            }
        }
    }

    public function testGetTransactionLicenseInfo(): void
    {
        $requestData = [
            'dp_command' => 'getTransactionLicenseInfo',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_transaction_id' => 123,
        ];

        $responseData = [
            'type' => 'success',
            'license' => [
                'id' => 9273,
                'name' => 'License',
                'fields' => [
                    [
                        'name' => 'project',
                        'placeholder' => 'Project',
                        'order' => '1',
                        'enabled' => true,
                        'type' => 'text',
                        'transaction_id' => '7542055',
                        'value' => 'name',
                    ],
                ],
                'transferId' => null,
                'size' => 'cs',
            ],
            'transaction' => [
                'id' => 75420505,
                'price' => '149.00',
                'size' => 'cs',
                'timestamp' => '1644591623',
                'currencyId' => '0',
            ],
            'item' => [
                'id' => 829036,
                'filename' => 'lion',
                'type' => 'image',
                'isEditorial' => false,
                'isNudity' => false,
                'preview' => 'https://st2.depositphotos.com/3609323/8235/i/110/depositphotos_829036-stock-photo-lion.jpg?forcejpeg=true',
                'width' => 3000,
                'height' => 2000,
            ],
            'from' => [
                'company' => 'Depositphotos Inc.',
                'fullName' => '',
                'address' => '115 West 30th Street',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10001',
                'email' => 'support@depositphotos.com',
                'phone' => '1-000-990-0071',
                'country' => 'US',
                'website' => 'www.depositphotos.com',
                'ein' => '46-0588',
                'vat' => null,
                'taxId' => null,
                'countryName' => 'United States',
            ],
            'to' => [
                'company' => 'company',
                'fullName' => 'Name',
                'address' => '17 Benaf Road',
                'city' => '',
                'state' => '',
                'zip' => '55405',
                'email' => 'tester@mail',
                'phone' => '+85208486',
                'country' => 'US',
                'website' => 'website',
                'ein' => null,
                'vat' => '',
                'taxId' => '',
                'countryName' => null,
            ],
            'transferredTo' => [
                'company' => 'company',
                'fullName' => 'Name',
                'address' => '17 Benaf Road',
                'city' => '',
                'state' => '',
                'zip' => '55405',
                'email' => 'tester@mail',
                'phone' => '+85208486',
                'country' => 'US',
                'website' => 'website',
                'ein' => null,
                'vat' => '',
                'taxId' => '',
                'countryName' => null,
            ],
        ];

        $resource = new LicenseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getTransactionLicenseInfo(new GetTransactionLicenseInfoRequest(
            $requestData['dp_session_id'],
            $requestData['dp_transaction_id']
        ));

        $this->assertEquals($responseData['license']['id'], $result->getLicense()->getId());
        $this->assertEquals($responseData['license']['name'], $result->getLicense()->getName());
        $this->assertEquals($responseData['license']['transferId'], $result->getLicense()->getTransferId());
        $this->assertEquals($responseData['license']['size'], $result->getLicense()->getSize());
        $this->assertEquals($responseData['license']['id'], $result->getLicense()->getId());

        foreach ($result->getLicense()->getFields() as $key => $field) {
            $this->assertEquals($responseData['license']['fields'][$key]['name'], $field->getName());
            $this->assertEquals($responseData['license']['fields'][$key]['placeholder'], $field->getPlaceholder());
            $this->assertEquals($responseData['license']['fields'][$key]['order'], $field->getOrder());
            $this->assertEquals($responseData['license']['fields'][$key]['enabled'], $field->isEnabled());
            $this->assertEquals($responseData['license']['fields'][$key]['type'], $field->getType());
            $this->assertEquals($responseData['license']['fields'][$key]['transaction_id'], $field->getTransactionId());
            $this->assertEquals($responseData['license']['fields'][$key]['value'], $field->getValue());
        }

        $this->assertEquals($responseData['transaction']['id'], $result->getTransaction()->getId());
        $this->assertEquals($responseData['transaction']['price'], $result->getTransaction()->getPrice());
        $this->assertEquals($responseData['transaction']['size'], $result->getTransaction()->getSize());
        $this->assertEquals($responseData['transaction']['timestamp'], $result->getTransaction()->getCreated()->getTimestamp());
        $this->assertEquals($responseData['transaction']['currencyId'], $result->getTransaction()->getCurrencyId());

        $this->assertEquals($responseData['item']['id'], $result->getItem()->getId());
        $this->assertEquals($responseData['item']['filename'], $result->getItem()->getFilename());
        $this->assertEquals($responseData['item']['type'], $result->getItem()->getType());
        $this->assertEquals($responseData['item']['isEditorial'], $result->getItem()->isEditorial());
        $this->assertEquals($responseData['item']['isNudity'], $result->getItem()->isNudity());
        $this->assertEquals($responseData['item']['preview'], $result->getItem()->getPreview());
        $this->assertEquals($responseData['item']['width'], $result->getItem()->getWidth());
        $this->assertEquals($responseData['item']['height'], $result->getItem()->getHeight());

        $this->assertLegalInfo($responseData['from'], $result->getFrom());
        $this->assertLegalInfo($responseData['to'], $result->getTo());
        $this->assertLegalInfo($responseData['transferredTo'], $result->getTransferredTo());
    }

    public function testTransferLicense(): void
    {
        $requestData = [
            'dp_command' => 'transferEnterpriseLicense',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_item_transaction_ids' => [123],
            'dp_from' => [
                'company' => 'Depositphotos Inc.',
                'full_name' => '',
                'address' => '115 West 30th Street',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '10001',
                'email' => 'support@depositphotos.com',
                'phone' => '1-000-990-0071',
                'country' => 'US',
                'website' => 'www.depositphotos.com',
                'ein' => '46-0588',
                'vat' => null,
                'country_name' => 'United States',
            ],
            'dp_to' => [
                'company' => 'company',
                'full_name' => 'Name',
                'address' => '17 Benaf Road',
                'city' => '',
                'state' => '',
                'zip' => '55405',
                'email' => 'tester@mail',
                'phone' => '+85208486',
                'country' => 'US',
                'website' => 'website',
                'ein' => null,
                'vat' => '',
                'country_name' => null,
            ],
        ];

        $responseData = [
            'type' => 'success',
        ];

        $resource = new LicenseResource($this->createHttpClient($requestData, $responseData));

        $fromLegalInfo = new LegalInfoRequest();
        $fromLegalInfo
            ->setCompany($requestData['dp_from']['company'])
            ->setFullName($requestData['dp_from']['full_name'])
            ->setAddress($requestData['dp_from']['address'])
            ->setCity($requestData['dp_from']['city'])
            ->setState($requestData['dp_from']['state'])
            ->setZip($requestData['dp_from']['zip'])
            ->setEmail($requestData['dp_from']['email'])
            ->setPhone($requestData['dp_from']['phone'])
            ->setCountry($requestData['dp_from']['country'])
            ->setWebsite($requestData['dp_from']['website'])
            ->setEin($requestData['dp_from']['ein'])
            ->setVat($requestData['dp_from']['vat'])
            ->setCountryName($requestData['dp_from']['country_name']);

        $toLegalInfo = new LegalInfoRequest();
        $toLegalInfo
            ->setCompany($requestData['dp_to']['company'])
            ->setFullName($requestData['dp_to']['full_name'])
            ->setAddress($requestData['dp_to']['address'])
            ->setCity($requestData['dp_to']['city'])
            ->setState($requestData['dp_to']['state'])
            ->setZip($requestData['dp_to']['zip'])
            ->setEmail($requestData['dp_to']['email'])
            ->setPhone($requestData['dp_to']['phone'])
            ->setCountry($requestData['dp_to']['country'])
            ->setWebsite($requestData['dp_to']['website'])
            ->setEin($requestData['dp_to']['ein'])
            ->setVat($requestData['dp_to']['vat'])
            ->setCountryName($requestData['dp_to']['country_name']);

        $resource->transferLicense(new TransferLicenseRequest(
            $requestData['dp_session_id'],
            $requestData['dp_item_transaction_ids'],
            $fromLegalInfo,
            $toLegalInfo
        ));
    }

    public function testGetTransferredLicenses(): void
    {
        $requestData = [
            'dp_command' => 'getTransferredLicenses',
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
                    'project' => 'Project',
                    'purchaseOrder' => 'Purchase Order',
                    'client' => 'Client',
                    'isbn' => 'Isbn',
                    'other' => 'Other'
                ],
            ],
            'count' => 1
        ];

        $resource = new LicenseResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getTransferredLicenses(new GetTransferredLicensesRequest(
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

        foreach ($result->getTransactions() as $key => $transaction) {
            $this->assertEquals($responseData['downloads'][$key]['itemTransactionId'], $transaction->getId());
            $this->assertEquals($responseData['downloads'][$key]['licenseTransferId'], $transaction->getLicenseTransferId());
            $this->assertEquals($responseData['downloads'][$key]['licenseId'], $transaction->getLicenseId());
            $this->assertEquals($responseData['downloads'][$key]['status'], $transaction->getStatus());
            $this->assertEquals($responseData['downloads'][$key]['currencyId'], $transaction->getCurrencyId());
            $this->assertEquals($responseData['downloads'][$key]['datetime'], $transaction->getCreated()->getTimestamp());
            $this->assertEquals($responseData['downloads'][$key]['groupId'], $transaction->getGroupId());
            $this->assertEquals($responseData['downloads'][$key]['marker'], $transaction->getMarker());
            $this->assertEquals($responseData['downloads'][$key]['filename'], $transaction->getItem()->getFileName());
            $this->assertEquals($responseData['downloads'][$key]['itemId'], $transaction->getItem()->getId());
            $this->assertEquals($responseData['downloads'][$key]['itemType'], $transaction->getItem()->getType());
            $this->assertEquals($responseData['downloads'][$key]['preview'], $transaction->getItem()->getPreview());
            $this->assertEquals($responseData['downloads'][$key]['width'], $transaction->getItem()->getWidth());
            $this->assertEquals($responseData['downloads'][$key]['height'], $transaction->getItem()->getHeight());
            $this->assertEquals($responseData['downloads'][$key]['editorial'], $transaction->getItem()->isEditorial());
            $this->assertEquals($responseData['downloads'][$key]['visible'], $transaction->getItem()->isVisible());
            $this->assertEquals($responseData['downloads'][$key]['userId'], $transaction->getUserId());
            $this->assertUser($responseData['downloads'][$key]['actor'], $transaction->getActor());
            $this->assertUser($responseData['downloads'][$key]['seller'], $transaction->getSeller());
            $this->assertEquals($responseData['downloads'][$key]['project'], $transaction->getProject());
            $this->assertEquals($responseData['downloads'][$key]['purchaseOrder'], $transaction->getPurchaseOrder());
            $this->assertEquals($responseData['downloads'][$key]['client'], $transaction->getClient());
            $this->assertEquals($responseData['downloads'][$key]['isbn'], $transaction->getIsbn());
            $this->assertEquals($responseData['downloads'][$key]['other'], $transaction->getOther());
        }
    }

    private function assertLegalInfo(array $expected, LegalInfo $legalInfo): void
    {
        $this->assertEquals($expected['company'], $legalInfo->getCompany());
        $this->assertEquals($expected['fullName'], $legalInfo->getFullName());
        $this->assertEquals($expected['address'], $legalInfo->getAddress());
        $this->assertEquals($expected['city'], $legalInfo->getCity());
        $this->assertEquals($expected['state'], $legalInfo->getState());
        $this->assertEquals($expected['zip'], $legalInfo->getZip());
        $this->assertEquals($expected['email'], $legalInfo->getEmail());
        $this->assertEquals($expected['phone'], $legalInfo->getPhone());
        $this->assertEquals($expected['country'], $legalInfo->getCountry());
        $this->assertEquals($expected['website'], $legalInfo->getWebsite());
        $this->assertEquals($expected['ein'], $legalInfo->getEin());
        $this->assertEquals($expected['vat'], $legalInfo->getVat());
        $this->assertEquals($expected['taxId'], $legalInfo->getTaxId());
        $this->assertEquals($expected['countryName'], $legalInfo->getCountryName());
    }

    private function assertUser(array $expected, User $user): void
    {
        $this->assertEquals($expected['id'], $user->getId());
        $this->assertEquals($expected['username'], $user->getUsername());
    }
}
