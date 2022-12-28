<?php

namespace App\Repositories\Stocks;

use App\Models\UserStockModel;
use App\Services\Database;

class DatabaseStocksRepository implements StocksRepository
{
    public function getStock($stockId, $symbol): UserStockModel
    {
        $userStock = Database::getConnection()->createQueryBuilder()
            ->select('*')
            ->from('stocks')
            ->where('user_id = ?')
            ->andWhere('symbol = ?')
            ->setParameter(0, $stockId)
            ->setParameter(1, $symbol)
            ->fetchAllAssociative();

        return new UserStockModel(
            $userStock[0]['user_id'],
            $userStock[0]['symbol'],
            $userStock[0]['amount'],
            $userStock[0]['price'],
        );
    }

    public function saveStock(int $id, string $symbol, int $amount, float $price): void
    {
        Database::getConnection()->insert('stocks', [
            'user_id' => $id,
            'symbol' => $symbol,
            'amount' => $amount,
            'price' => $price,

        ]);
    }

    public function transferStock(UserStockModel $stock, $userId, $symbol, $amount): void
    {
        $userStockAmount = Database::getConnection()->createQueryBuilder()
            ->select('amount')
            ->from('stocks')
            ->where('user_id = ?')
            ->andWhere('symbol = ?')
            ->setParameter(0, $userId)
            ->setParameter(1, $symbol)
            ->fetchOne();

        if (!$userStockAmount) {
            Database::getConnection()->insert('stocks', [
                'user_id' => $userId,
                'symbol' => $symbol,
                'amount' => $amount,
                'price' => $stock->getPrice(),
            ]);

        } else {
            Database::getConnection()->update('stocks',
                ['amount' => $userStockAmount + $amount],
                ['user_id' => $userId, 'symbol' => $symbol]
            );
        }
    }

    public function updateStock($userId, $totalAmount, $symbol): void
    {
        if ($totalAmount === 0) {
            Database::getConnection()->delete('stocks',
                ['user_id' => $userId, 'symbol' => $symbol],
            );
        } else {
            Database::getConnection()->update('stocks',
                ['amount' => $totalAmount],
                ['user_id' => $userId, 'symbol' => $symbol]
            );
        }
    }

    public function getStockBySymbol($symbol, $userId): ?UserStockModel
    {
        $userStock = Database::getConnection()->createQueryBuilder()
            ->select('*')
            ->from('stocks')
            ->where('user_id = ?')
            ->andWhere('symbol = ?')
            ->setParameter(0, $userId)
            ->setParameter(1, $symbol)
            ->fetchAssociative();

        if (!$userStock) {
            return null;
        }

        return new UserStockModel(
            $userStock['user_id'],
            $userStock['symbol'],
            $userStock['amount'],
            $userStock['price'],
        );
    }
}
