<?php

namespace App\ViewVariables;

use App\Services\Database;

class StocksViewVariables implements ViewVariables
{
    public function getName(): string
    {
        return 'boughtStocks';
    }

    public function getValue(): array
    {
        if(! isset($_SESSION['auth_id'])) {
            return [];
        }

        $queryBuilder = Database::getConnection()->createQueryBuilder();

        return $queryBuilder
            ->select('*')
            ->from('stocks')
            ->where('user_id = ?')
            ->setParameter(0, $_SESSION['auth_id'])
            ->fetchAllAssociative();
    }
}