<?php

namespace App\Validation\BuySellStocksValidation;

class MoneyValidation implements StocksValidationInterface
{
    private int $totalMoney;

    public function __construct(int $totalMoney)
    {
        $this->totalMoney = $totalMoney;
    }

    public function success(): bool
    {
        if($this->totalMoney < 0) {
            return false;
        }
        return true;
    }
}