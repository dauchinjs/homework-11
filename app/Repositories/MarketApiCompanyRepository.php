<?php

namespace App\Repositories;

use Finnhub;
use GuzzleHttp;

class MarketApiCompanyRepository implements CompanyRepository
{
    private string $apiKey;
    public function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'];
    }
    public function getQuote(string $symbol): Finnhub\Model\Quote
    {
        return ($this->getClient()->quote($symbol));
    }
    public function getProfile(string $symbol): Finnhub\Model\CompanyProfile2
    {
        return ($this->getClient()->companyProfile2($symbol));
    }
    private function getClient(): Finnhub\Api\DefaultApi
    {
        $config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', $this->apiKey);
        return new Finnhub\Api\DefaultApi(
            new GuzzleHttp\Client(),
            $config
        );
    }
}