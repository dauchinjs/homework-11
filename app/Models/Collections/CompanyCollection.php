<?php

namespace App\Models\Collections;

use App\Models\Company;

class CompanyCollection
{
    private array $companies = [];

    public function __construct(array $companies = [])
    {
        foreach($companies as $company) {
            $this->add($company);
        }
    }
    public function add(Company $company): void
    {
        $this->companies [] = $company;
    }

    public function get(): array
    {
        return $this->companies;
    }
}
