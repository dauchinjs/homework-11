<?php

namespace App\ViewVariables;

use App\Services\Database;

class TransactionsViewVariables implements ViewVariables
{

    public function getName(): string
    {
        return "transactions";
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
            ->orderBy('id', 'DESC')
            ->fetchAllAssociative();

        foreach ($transactions as $key => $transaction) {
            $transactions[$key]['profit'] = number_format($transaction['profit'], 2);
            $transactions[$key]['price'] = number_format($transaction['price'], 2);
            $transactions[$key]['amount'] = number_format($transaction['amount'], 2);
        }

        return $transactions;
    }
}