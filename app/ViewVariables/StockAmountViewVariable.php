<?php

namespace App\ViewVariables;

use App\Services\Database;

class StockAmountViewVariable implements ViewVariables
{
    public function getName(): string
    {
        return 'stockAmount';
    }

    public function getValue(): array
    {
        if(! isset($_SESSION['auth_id'])) {
            return [];
        }

        $queryBuilder = Database::getConnection()->createQueryBuilder();

        $amount = $queryBuilder
            ->select('amount')
            ->from('stocks')
            ->where('symbol = ?')
            ->andWhere('user_id = ?')
            ->setParameter(0, $_GET['symbol'])
            ->setParameter(1, $_SESSION['auth_id'])
            ->fetchAllAssociative();
//var_dump($_GET['symbol']);die;
        return [
            'amount' => $amount[0]['amount'],
        ];
    }
}