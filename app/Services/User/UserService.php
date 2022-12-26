<?php

namespace App\Services\User;

use App\Models\UserStockModel;
use App\Repositories\UserManagement\MySQLUsersRepository;
use App\Repositories\UserManagement\UsersRepository;

class UserService
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MySQLUsersRepository();
    }

    public function getUserByEmail(string $email): ?array
    {
        return $this->usersRepository->getByEmail($email);
    }

    public function getUserByID(int $id): ?array
    {
        return $this->usersRepository->getByID($id);
    }

    public function getUserStocks(int $id): array
    {
        return $this->usersRepository->getUserStocks($id);
    }

    public function getAmountOwned(int $id, string $symbol): ?int
    {
        return $this->usersRepository->getAmountOwned($id, $symbol);
    }
    public function getBalance(int $id): ?float
    {
        return $this->usersRepository->getBalance($id);
    }

    public function getUserStock(int $id, string $symbol): ?UserStockModel
    {
        return $this->usersRepository->getUserStock($id, $symbol);
    }
}