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

        $shortProfit = 0;
        $longProfit = 0;

        foreach ($transactions as $transaction) {
            if ($transaction['action'] === 'sell') {
                $longProfit += $transaction['profit'];
            } else {
                $shortProfit += $transaction['profit'];
            }
        }

        return [
            'shortProfit' => $shortProfit,
            'longProfit' => $longProfit,
        ];
    }
}