<?php

namespace App\Repositories\Transactions;

use App\Models\Stock;
use App\Models\UserStockModel;

interface TransactionsRepository
{
    public function sellTransaction(Stock $stock, float $profit, int $amount, int $userId);
    public function buyTransaction(Stock $stock, float $profit, int $amount, int $userId);
    public function transferTransaction(UserStockModel $stock, int $userId, int $amount, string $symbol);
}