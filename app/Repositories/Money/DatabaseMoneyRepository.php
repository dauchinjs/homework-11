<?php

namespace App\Repositories\Money;

use App\Services\Database;

class DatabaseMoneyRepository implements MoneyRepository
{
    private float $money;

    public function __construct()
    {
        $queryBuilder = Database::getConnection()->createQueryBuilder();

        $this->money = $queryBuilder
            ->select('balance')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $_SESSION['auth_id'])
            ->fetchOne();
    }
    public function getMoney(): float
    {
        return $this->money;
    }

    public function updateMoney($moneyAmount, $userId): void
    {
        Database::getConnection()->update('users', [
                'balance' => $moneyAmount
            ], [
                'id' => $userId
            ]);
    }
}