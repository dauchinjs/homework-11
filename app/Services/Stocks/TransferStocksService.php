<?php

namespace App\Services\Stocks;

use App\Models\UserStockModel;
use App\Repositories\Stocks\DatabaseStocksRepository;
use App\Repositories\Transactions\DatabaseTransactionsRepository;

class TransferStocksService
{
    private DatabaseStocksRepository $stocksRepository;
    private DatabaseTransactionsRepository $transactionsRepository;

    public function __construct()
    {
        $this->stocksRepository = new DatabaseStocksRepository();
        $this->transactionsRepository = new DatabaseTransactionsRepository();
    }

    public function getStockBySymbol(string $symbol): ?UserStockModel
    {
        return $this->stocksRepository->getStockBySymbol($symbol);
    }
    public function updateStock(int $userId, int $stockAmount, string $symbol): void
    {
        $this->stocksRepository->updateStock($userId, $stockAmount, $symbol);
    }

    public function getStock(int $stockId, string $symbol): UserStockModel
    {
        return $this->stocksRepository->getStock($stockId, $symbol);
    }

    public function transferStock(UserStockModel $stock, int $userId, string $symbol, int $amount): void
    {
        $this->stocksRepository->transferStock($stock, $userId, $symbol, $amount);
    }

    public function transferTransaction(UserStockModel $stock, int $userId, int $amount, string $symbol): void
    {
        $this->transactionsRepository->transferTransaction($stock, $userId, $amount, $symbol);
    }
}