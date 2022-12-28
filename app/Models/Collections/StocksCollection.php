<?php

namespace App\Models\Collections;

use App\Models\Stock;

class StocksCollection
{
    private array $companies = [];

    public function __construct(array $companies = [])
    {
        foreach($companies as $company) {
            $this->add($company);
        }
    }
    public function add(Stock $company): void
    {
        $this->companies [] = $company;
    }

    public function get(): array
    {
        return $this->companies;
    }
}
