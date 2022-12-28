<?php

namespace App\Services\Transactions;

use App\Repositories\Transactions\DatabaseTransactionsRepository;

class TransactionService
{
    private DatabaseTransactionsRepository $databaseTransactionsRepository;

    public function __construct()
    {
        $this->databaseTransactionsRepository = new DatabaseTransactionsRepository();
    }

    public function sellTransaction($stock, $profit, $amount, $userId)
    {
        $this->databaseTransactionsRepository->sellTransaction($stock, $profit, $amount, $userId);
    }

    public function buyTransaction($stock, $profit, $amount, $userId)
    {
        $this->databaseTransactionsRepository->buyTransaction($stock, $profit, $amount, $userId);
    }
}