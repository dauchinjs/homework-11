<?php

namespace App\Controllers\BuySellControllers;

use App\Redirect;
use App\Services\Money\MoneyService;
use App\Services\Stocks\StockService;
use App\Services\Stocks\PurchaseStockService;
use App\Services\Transactions\TransactionService;
use App\Services\User\UserService;
use App\Template;
use App\Validation\BuySellStocksValidation\MoneyValidation;

class BuySellController
{
    private StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index(): Template
    {
        $stocks = $this->stockService->getStock($_GET['symbol']);

        return new Template(
            'buySell.twig',
            [
                'stocks' => $stocks,
            ]
        );
    }

    public function execute(): Redirect
    {
        $service = new PurchaseStockService();
        $stockService = $this->stockService->getStock($_GET['symbol']);
        $userService = new UserService();

        $moneyService = new MoneyService();
        $money = $moneyService->getMoney();

        $totalMoney = $money + ($stockService->getCurrentPrice() * (int)$_POST['sell']) -
            ($stockService->getCurrentPrice() * (int)$_POST['buy']);

        $moneyValidation = new MoneyValidation($totalMoney);
        if (!$moneyValidation->success()) {
            $_SESSION['error']['insufficientFunds'] = true;

            return new Redirect('/buySell?symbol=' . $_GET['symbol']);
        }

        $moneyService->updateMoney($totalMoney, $_SESSION['auth_id']);

        $ownedAmount = $userService->getAmountOwned($_SESSION['auth_id'], $_GET['symbol']);
        $totalAmount = $ownedAmount + (int)$_POST['buy'] - (int)$_POST['sell'];

        $transactionService = new TransactionService();

        if ($_POST['sell'] !== '') {
            if($ownedAmount <= 0) {
                $service->execute(
                    $_SESSION['auth_id'],
                    $_GET['symbol'],
                    $stockService->getCurrentPrice(),
                    $totalAmount,
                );
                $sellProfit = $stockService->getCurrentPrice() * (int)$_POST['sell'] -
                    $userService->getUserStock($_SESSION['auth_id'], $_GET['symbol'])->getPrice() * (int)$_POST['sell'];
                $transactionService->sellTransaction($stockService, $sellProfit, $_POST['sell'], $_SESSION['auth_id']);
            } else {
                $sellProfit = $stockService->getCurrentPrice() * (int)$_POST['sell'] -
                    $userService->getUserStock($_SESSION['auth_id'], $_GET['symbol'])->getPrice() * (int)$_POST['sell'];
                $transactionService->sellTransaction($stockService, $sellProfit, $_POST['sell'], $_SESSION['auth_id']);
                $service->execute(
                    $_SESSION['auth_id'],
                    $_GET['symbol'],
                    $stockService->getCurrentPrice(),
                    $totalAmount,
                );
            }
        }
        if ($_POST['buy'] !== '') {
            if($ownedAmount < 0) {
                $buyProfit = $stockService->getCurrentPrice() * (int)$_POST['buy'] -
                    $userService->getUserStock($_SESSION['auth_id'], $_GET['symbol'])->getPrice() * (int)$_POST['buy'];
                $transactionService->buyTransaction($stockService, $buyProfit, $_POST['buy'], $_SESSION['auth_id']);
                $service->execute(
                    $_SESSION['auth_id'],
                    $_GET['symbol'],
                    $stockService->getCurrentPrice(),
                    $totalAmount
                );
            } else {
                $service->execute(
                    $_SESSION['auth_id'],
                    $_GET['symbol'],
                    $stockService->getCurrentPrice(),
                    $totalAmount
                );
                $buyProfit = $stockService->getCurrentPrice() * (int)$_POST['buy'] -
                    $userService->getUserStock($_SESSION['auth_id'], $_GET['symbol'])->getPrice() * (int)$_POST['buy'];
                $transactionService->buyTransaction($stockService, $buyProfit, $_POST['buy'], $_SESSION['auth_id']);
            }
        }
        
        return new Redirect('/buySell?symbol=' . $_GET['symbol']);
    }
}
