<?php

namespace App\Repositories;

use Finnhub;
interface CompanyRepository
{
    public function getQuote(string $symbol): Finnhub\Model\Quote;
    public function getProfile(string $symbol): Finnhub\Model\CompanyProfile2;
}