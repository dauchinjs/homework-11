<?php

namespace App\Repositories\Transactions;

use App\Models\Stock;
use App\Models\UserStockModel;
use App\Services\Database;

class DatabaseTransactionsRepository implements TransactionsRepository
{
    public function sellTransaction(Stock $stock, float $profit, int $amount, int $userId)
    {
        Database::getConnection()->insert('transactions', [
            'user_id' => $userId,
            'symbol' => $stock->getTicker(),
            'price' => $stock->getCurrentPrice(),
            'amount' => $amount,
            'profit' => $profit,
            'action' => 'sell'
        ]);
    }

    public function buyTransaction(Stock $stock, float $profit, int $amount, int $userId)
    {
        Database::getConnection()->insert('transactions', [
            'user_id' => $userId,
            'symbol' => $stock->getTicker(),
            'price' => $stock->getCurrentPrice(),
            'amount' => $amount,
            'profit' => $profit,
            'action' => 'buy'
        ]);
    }
    public function transferTransaction(UserStockModel $stock, int $userId, int $amount, string $symbol)
    {
        Database::getConnection()->insert('transactions', [
            'user_id' => $userId,
            'symbol' => $symbol,
            'price' => $stock->getPrice(),
            'amount' => $amount,
            'profit' => 0,
            'action' => 'transfer'
        ]);
    }
}