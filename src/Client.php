<?php
declare(strict_types=1);

namespace Depositphotos\SDK;

use Depositphotos\SDK\Http\HttpConfigurator;
use Depositphotos\SDK\Http\HttpClient;

class Client
{
    /** @var HttpClient */
    protected $httpClient;

    public function __construct(HttpConfigurator $httpConfigurator)
    {
        $this->httpClient = $httpConfigurator->makeConfiguredHttpClient();
    }

    public static function createRegularClient( string $apiKey, string $endpoint): RegularClient
    {
        return new RegularClient(new HttpConfigurator($apiKey, $endpoint));
    }

    public static function createEnterpriseClient(string $apiKey, string $endpoint): EnterpriseClient
    {
        return new EnterpriseClient(new HttpConfigurator($apiKey, $endpoint));
    }

    public static function createCorporateClient(string $apiKey, string $endpoint): CorporateClient
    {
        return new CorporateClient(new HttpConfigurator($apiKey, $endpoint));
    }
}
