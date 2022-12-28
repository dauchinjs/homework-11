<?php

namespace App\Controllers\StocksController;

use App\Services\Stocks\StockService;
use App\Template;

class StocksController
{
    private StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }
    public function execute(): Template
    {
        $stockSymbols = $this->stockService->getAllStocks(
            [
                'AAPL',
                'TSLA',
                'NVDA',
                'MA',
                'KO',
                'NKE',
                'DIS',
                'UPS',
                'NFLX',
                'PYPL'
            ]
        );

        return new Template(
            'index.twig',
            ['companies' => $stockSymbols->get()]
        );
    }
    public function search(): Template
    {
        $company = $this->stockService->getStock($_GET['search']);
        return new Template(
            'show.twig',
            ['company' => $company]
        );
    }
}