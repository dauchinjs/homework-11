<?php

namespace App\ViewVariables;

use App\Services\User\UserService;

class UserStocksViewVariables implements ViewVariables
{
    public function getName(): string
    {
        return 'userStock';
    }

    public function getValue(): array
    {
        if(!isset($_SESSION['stock_id'])) {
            return [];
        }

        $service = new UserService();
        $stock = $service->getUserByID($_SESSION['stock_id']);

        return [
            'id' => $stock['user_id'],
            'symbol' => $stock['symbol'],
            'price' => $stock['price'],
            'amount' => $stock['amount'],
        ];
    }
}