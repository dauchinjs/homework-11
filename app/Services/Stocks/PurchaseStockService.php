<?php

namespace App\Services\Stocks;

use App\Repositories\Stocks\DatabaseStocksRepository;
use App\Repositories\Stocks\StocksRepository;
use App\Repositories\User\StockMarketUserRepository;
use App\Repositories\User\UserRepository;

class PurchaseStockService
{
    private UserRepository $userRepository;
    private StocksRepository $stocksRepository;


    public function __construct()
    {
        $this->userRepository = new StockMarketUserRepository();
        $this->stocksRepository = new DatabaseStocksRepository();
    }

    public function execute(int $id, string $symbol, float $price, int $amount): void
    {
        $user = $this->userRepository->getUserById($id);
        $stock = $this->stocksRepository->getStockBySymbol($symbol);

        if ($stock === null) {
            $this->stocksRepository->saveStock($user->getId(), $symbol, $amount, $price);
        } else {
            $this->stocksRepository->updateStock($user->getId(), $amount, $symbol);
        }
    }
}