<?php

namespace App\Models;

class Company
{
    private float $currentPrice;
    private float $change;
    private float $percentChange;
    private float $highPrice;
    private float $lowPrice;
    private float $openPrice;
    private float $previousClosePrice;

    public function __construct(
        float $currentPrice,
        float $change,
        float $percentChange,
        float $highPrice,
        float $lowPrice,
        float $openPrice,
        float $previousClosePrice
    )
    {
        $this->currentPrice = $currentPrice;
        $this->change = $change;
        $this->percentChange = $percentChange;
        $this->highPrice = $highPrice;
        $this->lowPrice = $lowPrice;
        $this->openPrice = $openPrice;
        $this->previousClosePrice = $previousClosePrice;
    }

    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }

    public function getChange(): float
    {
        return $this->change;
    }

    public function getPercentChange(): float
    {
        return $this->percentChange;
    }

    public function getHighPrice(): float
    {
        return $this->highPrice;
    }

    public function getLowPrice(): float
    {
        return $this->lowPrice;
    }

    public function getOpenPrice(): float
    {
        return $this->openPrice;
    }

    public function getPreviousClosePrice(): float
    {
        return $this->previousClosePrice;
    }
}