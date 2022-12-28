<?php
// 3gifi no 3 dazadam vietam ka strada. readme.md faila githuba - jaapraksta kas notiek, php versija, mysql versija, uzstadisanas process
// un tad 3 gifi apaksa. jaeksporte datubaze bez datiem (eksporte datubazes shemu) (.sql dump fails) tas ta lai nebutu jaunam lietotajam jataisa datubaze
//sis bus musu pirmais job-seeker-diary projekts


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
        if ($moneyValidation->success() === true) {
            $_SESSION['success']['operation'] = true;
        } else {
            $_SESSION['error']['insufficientFunds'] = true;

            return new Redirect('/buySell?symbol=' . $_GET['symbol']);
        }

        $moneyService->updateMoney($totalMoney, $_SESSION['auth_id']);

        $ownedAmount = $userService->getAmountOwned($_SESSION['auth_id'], $_GET['symbol']);
        $totalAmount = $ownedAmount + (int)$_POST['buy'] - (int)$_POST['sell'];

        $transactionService = new TransactionService();

        $boughtStock = $userService->getUserStock($_SESSION['auth_id'], $_GET['symbol']);

        if ($boughtStock === null) {
            $boughtStock = $stockService->getCurrentPrice();
        } else {
            $boughtStock = $boughtStock->getPrice();
        }

        if ($_POST['sell'] !== '') {
            if ($ownedAmount <= 0) {
                $service->execute(
                    $_SESSION['auth_id'],
                    $_GET['symbol'],
                    $stockService->getCurrentPrice(),
                    $totalAmount,
                );
//                $sellProfit = $stockService->getCurrentPrice() * (int)$_POST['sell'] -
//                    $boughtStock * (int)$_POST['sell'];
                $longProfit = 0;
                $transactionService->sellTransaction($stockService, $longProfit, $_POST['sell'], $_SESSION['auth_id']);
            } else {
                $longProfit = $stockService->getCurrentPrice() * (int)$_POST['sell'] -
                    $boughtStock * (int)$_POST['sell'];
                $transactionService->sellTransaction($stockService, $longProfit, $_POST['sell'], $_SESSION['auth_id']);
                $service->execute(
                    $_SESSION['auth_id'],
                    $_GET['symbol'],
                    $stockService->getCurrentPrice(),
                    $totalAmount,
                );
            }
        }
        if ($_POST['buy'] !== '') {
            if ($ownedAmount < 0) {
                $shortProfit = $boughtStock * (int)$_POST['buy'] - $stockService->getCurrentPrice() * (int)$_POST['buy'];
                $transactionService->buyTransaction($stockService, $shortProfit, $_POST['buy'], $_SESSION['auth_id']);
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
//                $buyProfit = $stockService->getCurrentPrice() * (int)$_POST['buy'] -
//                    $boughtStock * (int)$_POST['buy'];
                $shortProfit = 0;
                $transactionService->buyTransaction($stockService, $shortProfit, $_POST['buy'], $_SESSION['auth_id']);
            }
        }

        return new Redirect('/buySell?symbol=' . $_GET['symbol']);
    }
}