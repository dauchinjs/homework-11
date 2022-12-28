<?php

namespace App\Models;

class UserStockModel
{
    private int $userID;
    private string $symbol;
    private int $amount;
    private ?float $price;

    public function __construct(int $userID, string $symbol, int $amount, ?float $price = null)
    {
        $this->userID = $userID;
        $this->symbol = $symbol;
        $this->amount = $amount;
        $this->price = $price;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }
}