<?php

namespace App\Repositories\Money;

interface MoneyRepository
{
    public function getMoney(): float;
    public function updateMoney($moneyAmount, $userId): void;
}