<?php

namespace App\Models;

class Stock
{
    private string $ticker;
    private string $name;
    private string $currency;
    private float $currentPrice;
    private float $percentChange;
    private float $previousClosePrice;

    public function __construct(
        string $ticker,
        string $name,
        string $currency,
        float $currentPrice,
        float $percentChange,
        float $previousClosePrice
    )
    {
        $this->ticker = $ticker;
        $this->name = $name;
        $this->currency = $currency;
        $this->currentPrice = $currentPrice;
        $this->percentChange = $percentChange;
        $this->previousClosePrice = $previousClosePrice;
    }
    public function getTicker(): string
    {
        return $this->ticker;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }
    public function getPercentChange(): float
    {
        return $this->percentChange;
    }

    public function getPreviousClosePrice(): float
    {
        return $this->previousClosePrice;
    }
}