<?php

namespace App\Services\Stocks;

use App\Models\Collections\StocksCollection;
use App\Models\Stock;
use App\Repositories\Company\CompanyRepository;

class StockService
{
    private CompanyRepository $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllStocks(array $symbols): StocksCollection
    {
        $companies = [];
        foreach ($symbols as $symbol) {
            $companies [] = $this->repository->getQuote($symbol);
        }
        return new StocksCollection($companies);
    }

    public function getStock(string $symbol): Stock
    {
        return $this->repository->getQuote($symbol);
    }

}