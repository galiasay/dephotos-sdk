<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Enterprise\Invoice;

use Depositphotos\SDK\Resource\Enterprise\Invoice\InvoiceResource;
use Depositphotos\SDK\Resource\Enterprise\Invoice\Request\CreateInvoiceRequest;
use Depositphotos\SDK\Resource\Enterprise\Invoice\Request\GetInvoiceCountRequest;
use Depositphotos\SDK\Resource\Enterprise\Invoice\Request\GetInvoiceListRequest;
use Depositphotos\SDK\Resource\Enterprise\Invoice\Request\GetInvoiceRequest;
use Depositphotos\SDK\Resource\Enterprise\Invoice\Response\GetInvoice\LegalInfo;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class InvoiceResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testCreateInvoice(): void
    {
        $requestData = [
            'dp_command' => 'createEnterpriseInvoice',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_item_transaction_ids' => [123],
            'dp_field_value' => 'Test',
        ];

        $responseData = [
            'type' => 'success',
            'invoiceId' => 1,
        ];

        $resource = new InvoiceResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->createInvoice(new CreateInvoiceRequest(
            $requestData['dp_session_id'],
            $requestData['dp_item_transaction_ids'],
            $requestData['dp_field_value']
        ));

        $this->assertEquals($responseData['invoiceId'], $result->getInvoiceId());
    }

    public function testGetInvoice(): void
    {
        $requestData = [
            'dp_command' => 'getEnterpriseInvoice',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_invoice_id' => 123,
        ];

        $responseData = [
            'type' => 'success',
            'invoice' => [
                'items' => [
                    [
                        'itemId' => 1178129,
                        'thumbUrl' => 'https://static3.depositphotos.com/...depositphotos_1178129.jpg',
                        'licenseInfo' => [],
                        'licenseId' => 30997745,
                        'licenseName' => 'Standard License',
                        'size' => 'cl',
                        'itemOriginalSize' => [
                            'height' => 2184,
                            'width' => 3276
                        ],
                        'type' => 'image',
                        'price' => '199.00',
                        'currencyId' => '0',
                        'vatPrice' => '199.00',
                        'vatRate' => null,
                        'tax' => [
                            'rate' => null,
                            'name' => null,
                            'region' => null
                        ],
                        'vatId' => '0',
                        'isEditorial' => false,
                        'isNudity' => false,
                    ],
                ],
                'state' => 'unpaid',
                'total' => 18,
                'vat' => 0,
                'tax' => [
                    'rate' => null,
                    'name' => null,
                    'region' => null,
                ],
                'subTotal' => 18,
                'id' => 8008396,
                'number' => 'ESI-15312676',
                'type' => 'file_invoice',
                'date' => 1644331085,
                'currencyId' => 0,
                'from' => [
                    'company' => 'Depositphotos Inc.',
                    'fullName' => '',
                    'address' => '115 West 30th Street',
                    'city' => 'New York',
                    'state' => 'NY',
                    'zip' => '10001',
                    'email' => 'support@depositphotos.com',
                    'phone' => null,
                    'country' => 'US',
                    'website' => null,
                    'ein' => '46-0588',
                    'vat' => null,
                    'taxId' => null,
                    'countryName' => 'United States',
                ],
                'to' => [
                    'company' => 'company',
                    'fullName' => 'Name',
                    'address' => '1790 Benaf Road',
                    'city' => '',
                    'state' => '',
                    'zip' => '55405',
                    'email' => 'tester@mail',
                    'phone' => '+856094486',
                    'country' => 'US',
                    'website' => 'website',
                    'ein' => null,
                    'vat' => '',
                    'taxId' => '9553454',
                    'countryName' => null,
                ],
                'paymentInstructions' => [
                    [
                        'key' => 'bankName',
                        'value' => 'Silicon Valley Bank',
                    ],
                ],
                'title' => 'File Invoice',
                'isProforma' => false,
                'paid' => 1644331085,
            ],
        ];

        $resource = new InvoiceResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getInvoice(new GetInvoiceRequest(
            $requestData['dp_session_id'],
            $requestData['dp_invoice_id']
        ));

        $this->assertEquals($responseData['invoice']['id'], $result->getId());
        $this->assertEquals($responseData['invoice']['state'], $result->getState());
        $this->assertEquals($responseData['invoice']['total'], $result->getTotal());
        $this->assertEquals($responseData['invoice']['vat'], $result->getVat());
        $this->assertEquals($responseData['invoice']['tax']['rate'], $result->getTax()->getRate());
        $this->assertEquals($responseData['invoice']['tax']['name'], $result->getTax()->getName());
        $this->assertEquals($responseData['invoice']['tax']['region'], $result->getTax()->getRegion());
        $this->assertEquals($responseData['invoice']['subTotal'], $result->getSubTotal());
        $this->assertEquals($responseData['invoice']['number'], $result->getNumber());
        $this->assertEquals($responseData['invoice']['type'], $result->getType());
        $this->assertEquals($responseData['invoice']['date'], $result->getDate()->getTimestamp());
        $this->assertEquals($responseData['invoice']['currencyId'], $result->getCurrencyId());
        $this->assertLegalInfo($responseData['invoice']['from'], $result->getFrom());
        $this->assertLegalInfo($responseData['invoice']['to'], $result->getTo());
        $this->assertEquals($responseData['invoice']['title'], $result->getTitle());
        $this->assertEquals($responseData['invoice']['isProforma'], $result->isProforma());
        $this->assertEquals($responseData['invoice']['paid'], $result->getPaid()->getTimestamp());

        foreach ($result->getPaymentInstructions() as $key => $paymentInstruction) {
            $this->assertEquals($responseData['invoice']['paymentInstructions'][$key]['key'], $paymentInstruction->getKey());
            $this->assertEquals($responseData['invoice']['paymentInstructions'][$key]['value'], $paymentInstruction->getValue());
        }

        foreach ($result->getItems() as $key => $item) {
            $this->assertEquals($responseData['invoice']['items'][$key]['itemId'], $item->getId());
            $this->assertEquals($responseData['invoice']['items'][$key]['thumbUrl'], $item->getThumbnail());
            $this->assertEquals($responseData['invoice']['items'][$key]['licenseInfo'], $item->getLicenseInfo());
            $this->assertEquals($responseData['invoice']['items'][$key]['licenseId'], $item->getLicenseId());
            $this->assertEquals($responseData['invoice']['items'][$key]['licenseName'], $item->getLicenseName());
            $this->assertEquals($responseData['invoice']['items'][$key]['size'], $item->getSize());
            $this->assertEquals($responseData['invoice']['items'][$key]['itemOriginalSize']['width'], $item->getItemOriginalWidth());
            $this->assertEquals($responseData['invoice']['items'][$key]['itemOriginalSize']['height'], $item->getItemOriginalHeight());
            $this->assertEquals($responseData['invoice']['items'][$key]['type'], $item->getType());
            $this->assertEquals($responseData['invoice']['items'][$key]['price'], $item->getPrice());
            $this->assertEquals($responseData['invoice']['items'][$key]['currencyId'], $item->getCurrencyId());
            $this->assertEquals($responseData['invoice']['items'][$key]['tax']['rate'], $item->getTax()->getRate());
            $this->assertEquals($responseData['invoice']['items'][$key]['tax']['name'], $item->getTax()->getName());
            $this->assertEquals($responseData['invoice']['items'][$key]['tax']['region'], $item->getTax()->getRegion());
            $this->assertEquals($responseData['invoice']['items'][$key]['vatPrice'], $item->getVatPrice());
            $this->assertEquals($responseData['invoice']['items'][$key]['vatId'], $item->getVatId());
            $this->assertEquals($responseData['invoice']['items'][$key]['vatRate'], $item->getVatRate());
            $this->assertEquals($responseData['invoice']['items'][$key]['isEditorial'], $item->isEditorial());
            $this->assertEquals($responseData['invoice']['items'][$key]['isNudity'], $item->isNudity());
        }
    }

    public function testGetInvoiceCount(): void
    {
        $requestData = [
            'dp_command' => 'getEnterpriseInvoiceCount',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_state' => 'paid',
            'dp_group_id' => 123,
        ];

        $responseData = [
            'type' => 'success',
            'count' => 10,
        ];

        $resource = new InvoiceResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getInvoiceCount(new GetInvoiceCountRequest(
            $requestData['dp_session_id'],
            $requestData['dp_state'],
            $requestData['dp_group_id']
        ));

        $this->assertEquals($responseData['count'], $result->getCount());
    }

    public function testGetInvoiceList(): void
    {
        $requestData = [
            'dp_command' => 'getEnterpriseInvoiceList',
            'dp_session_id' => 'e9753fbbd7454ea001b7619ce1e20fe5',
            'dp_limit' => 10,
            'dp_offset' => 0,
            'dp_state' => 'unpaid',
        ];

        $responseData = [
            'type' => 'success',
            'data' => [
                [
                    'id' => 8089244,
                    'date' => 1642517947,
                    'title' => 'File Invoice',
                    'number' => 'ESI-1531258792',
                    'type' => 'file_invoice',
                    'price' => 11,
                    'amount' => 11,
                    'currencyId' => 0,
                    'paymentDate' => 1642518031,
                    'isProforma' => false
                ],
            ]
        ];

        $resource = new InvoiceResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getInvoiceList(new GetInvoiceListRequest(
            $requestData['dp_session_id'],
            $requestData['dp_limit'],
            $requestData['dp_offset'],
            $requestData['dp_state']
        ));

        foreach ($result->getInvoices() as $key => $invoice) {
            $this->assertEquals($responseData['data'][$key]['id'], $invoice->getId());
            $this->assertEquals($responseData['data'][$key]['date'], $invoice->getDate()->getTimestamp());
            $this->assertEquals($responseData['data'][$key]['title'], $invoice->getTitle());
            $this->assertEquals($responseData['data'][$key]['number'], $invoice->getNumber());
            $this->assertEquals($responseData['data'][$key]['type'], $invoice->getType());
            $this->assertEquals($responseData['data'][$key]['price'], $invoice->getPrice());
            $this->assertEquals($responseData['data'][$key]['amount'], $invoice->getAmount());
            $this->assertEquals($responseData['data'][$key]['currencyId'], $invoice->getCurrencyId());
            $this->assertEquals($responseData['data'][$key]['paymentDate'], $invoice->getPaid()->getTimestamp());
            $this->assertEquals($responseData['data'][$key]['isProforma'], $invoice->isProforma());
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
}
