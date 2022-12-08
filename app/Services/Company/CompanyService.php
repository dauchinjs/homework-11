<?php

namespace App\Services\Company;

use App\Repositories\CompanyRepository;
use App\Repositories\MarketApiCompanyRepository;
use Finnhub;
class CompanyService
{
    private CompanyRepository $companyRepository;
    public function __construct()
    {
        $this->companyRepository = new MarketApiCompanyRepository();
    }
    public function getQuote(string $symbol): Finnhub\Model\Quote
    {
        return $this->companyRepository->getQuote($symbol);
    }
    public function getProfile(string $symbol): Finnhub\Model\CompanyProfile2
    {
        return $this->companyRepository->getProfile($symbol);
    }

}