<?php

namespace App\Repositories\Company;

use App\Models\Stock;
use Finnhub\Api\DefaultApi;
use Finnhub\Configuration;
use GuzzleHttp\Client;

class MarketApiStocksRepository implements CompanyRepository
{

    private DefaultApi $client;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('token', $_ENV['API_KEY']);
        $this->client = new DefaultApi(
            new Client(),
            $config
        );
    }
    public function getQuote(string $symbols): Stock
    {
        $ticker = json_decode($this->client->companyProfile2($symbols)->toHeaderValue(), true)['ticker'];
        $name = json_decode($this->client->companyProfile2($symbols)->toHeaderValue(), true)['name'];
        $currency = json_decode($this->client->companyProfile2($symbols)->toHeaderValue(), true)['currency'];
        $currentPrice = json_decode($this->client->quote($symbols)->toHeaderValue(), true)['c'];
        $percentChange = json_decode($this->client->quote($symbols)->toHeaderValue(), true)['dp'];
        $previousClosePrice = json_decode($this->client->quote($symbols)->toHeaderValue(), true)['pc'];

        return new Stock($ticker, $name, $currency, $currentPrice, $percentChange,$previousClosePrice);
    }
}