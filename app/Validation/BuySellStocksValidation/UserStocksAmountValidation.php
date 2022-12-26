<?php

namespace App\Validation\BuySellStocksValidation;

class UserStocksAmountValidation implements StocksValidationInterface
{
    private ?float $userStocksAmount;
    private string $amount;

    public function __construct(?float $userStocksAmount, string $amount)
    {
        $this->userStocksAmount = $userStocksAmount;
        $this->amount = $amount;
    }

    public function success(): bool
    {
        if($this->userStocksAmount - (float)$this->amount < 0) {
            return false;
        }
        return true;
    }
}