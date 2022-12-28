<?php

namespace App\Controllers\BuySellControllers;

use App\Template;

class TransactionsController
{
    public function showForm(): Template
    {
        return new Template('transactions.twig');
    }
}