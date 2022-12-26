<?php

namespace App\Controllers\UserControllers;

use App\Redirect;
use App\Services\Money\MoneyService;
use App\Validation\BuySellStocksValidation\MoneyValidation;

class MoneyController
{
    public function depositWithdraw(): Redirect
    {
        $moneyService = new MoneyService();

        $money = $moneyService->getMoney();

        $totalMoney = $_POST['deposit'] + $money - $_POST['withdraw'];
        $moneyValidation = new MoneyValidation($totalMoney);

        if($moneyValidation->success()) {
            $moneyService->updateMoney($totalMoney);
            return new Redirect('/profile');
        }
        $_SESSION['error']['insufficientFundsInWallet'] = true;

        return new Redirect('/profile');
    }
}