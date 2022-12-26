<?php

namespace App\Repositories\UserManagement;

use App\Models\UserStockModel;
use App\Services\Register\RegisterServiceRequest;

interface UsersRepository
{
    public function getByEmail(string $email): ?array;
    public function getByID(int $id): ?array;
    public function getUserStocks(int $id): ?array;
    public function getAmountOwned(int $id, string $symbol): ?int;
    public function getBalance(int $id): ?float;
    public function getUserStock(int $id, string $symbol): ?UserStockModel;
}