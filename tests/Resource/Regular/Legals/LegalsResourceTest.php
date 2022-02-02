<?php
declare(strict_types=1);

namespace Depositphotos\SDK\Tests\Resource\Regular\Legals;

use Depositphotos\SDK\Resource\Regular\Legals\LegalsResource;
use Depositphotos\SDK\Resource\Regular\Legals\Request\GetLegalDocumentRequest;
use Depositphotos\SDK\Resource\Regular\Legals\Request\GetLegalsListRequest;
use Depositphotos\SDK\Tests\BaseTestCase;
use Depositphotos\SDK\Tests\Resource\ResourceTrait;

class LegalsResourceTest extends BaseTestCase
{
    use ResourceTrait;

    public function testGetLegalsList(): void
    {
        $requestData = [
            'dp_command' => 'getLegalsList',
        ];

        $responseData = [
            'type' => 'success',
            'legals' => [
                'terms-of-use',
                'privacy-policy',
                'dmca',
                'member-agreement-text',
                'content-license',
                'standard-license',
                'extended-license',
                'comparison',
                'subscription-agreement',
                'cancellation-policy'
            ],
        ];

        $resource = new LegalsResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getLegalsList(new GetLegalsListRequest());

        $this->assertEquals($responseData['legals'], $result->getLegals());
    }

    public function testGetLegalDocument(): void
    {
        $requestData = [
            'dp_command' => 'getLegalDocument',
            'dp_legal_name' => 'terms-of-use',
            'dp_lang' => null,
        ];

        $responseData = [
            'type' => 'success',
            'document' => 'Document contents',
        ];

        $resource = new LegalsResource($this->createHttpClient($requestData, $responseData));
        $result = $resource->getLegalDocument(new GetLegalDocumentRequest(
            $requestData['dp_legal_name'],
            $requestData['dp_lang']
        ));

        $this->assertEquals($responseData['document'], $result->getDocument());
    }
}
