<?php

namespace App\Services\Money;

use App\Repositories\Money\DatabaseMoneyRepository;

class MoneyService
{
    private DatabaseMoneyRepository $moneyRepository;

    public function __construct()
    {
        $this->moneyRepository = new DatabaseMoneyRepository();
    }

    public function getMoney()
    {
        return $this->moneyRepository->getMoney();
    }

    public function updateMoney($money, $userId)
    {
        $this->moneyRepository->updateMoney($money, $userId);
    }
}