<?php

namespace App\ViewVariables;

use App\Services\Database;

class ProfitViewVariables implements ViewVariables
{
    public function getName(): string
    {
        return 'overall';
    }

    public function getValue(): array
    {
        if (!isset($_SESSION['auth_id'])) {
            return [];
        }

        $queryBuilder = Database::getConnection()->createQueryBuilder();

        $transactions = $queryBuilder
            ->select('*')
            ->from('transactions')
            ->where('user_id = ?')
            ->setParameter(0, $_SESSION['auth_id'])
            ->fetchAllAssociative();

        $buyProfit = 0;
        $sellProfit = 0;

        foreach ($transactions as $transaction) {
            if ($transaction['action'] === 'sell') {
                $sellProfit += $transaction['profit'];
            } else {
                $buyProfit += $transaction['profit'];
            }
        }
        $totalProfit = $sellProfit + $buyProfit;

        return [
            'totalProfit' => $totalProfit,
            'sellProfit' => $sellProfit,
            'buyProfit' => $buyProfit,
        ];
    }
}