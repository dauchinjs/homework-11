<?php

namespace App\Repositories\Company;

use App\Models\Stock;

interface CompanyRepository
{
    public function getQuote(string $symbols): Stock;
}