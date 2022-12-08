<?php

namespace App\Controllers\CompanyControllers;


use App\Services\Company\CompanyService;
use App\Template;

class CompanyController
{
    public function execute(): Template
    {
        $symbol = $_GET['symbol'] ?? 'NKE';
        $companies = (new CompanyService())->getQuote($symbol);
        $companyProfile = (new CompanyService())->getProfile($symbol);

        return new Template(
            'index.twig',
            ['companies' => $companies, 'companyProfile' => $companyProfile]
        );
    }
}


//use Dotenv\Dotenv;
//require_once "vendor/autoload.php";
//
//$dotenv = Dotenv::createImmutable('/home/davids/Desktop/CODELEX/9.dala');
//$dotenv->load();
//
//$config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'ce8cbhaad3i1ljtnrt70ce8cbhaad3i1ljtnrt7g');
//$client = new Finnhub\Api\DefaultApi(
//    new GuzzleHttp\Client(),
//    $config
//);
//echo "<pre>";
//echo ($client->companyProfile2("PYPL"));
////print_r($client->companyBasicFinancials("AAPL", "all"));
//echo ($client->quote("PYPL"));die;