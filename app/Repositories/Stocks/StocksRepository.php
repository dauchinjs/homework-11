<?php

namespace App\Repositories\Stocks;

use App\Models\UserStockModel;

interface StocksRepository
{
    public function getStock($stockId, $symbol): UserStockModel;
    public function saveStock(int $id, string $symbol,int $amount, float $price): void;
    public function transferStock(UserStockModel $stock, $userId, $symbol, $amount): void;
    public function updateStock($userId, $totalAmount, $symbol): void;
    public function getStockBySymbol($symbol);
}