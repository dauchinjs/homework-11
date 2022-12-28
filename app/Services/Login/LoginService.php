<?php

namespace App\Services\Login;

use App\Models\User;
use App\Repositories\User\StockMarketUserRepository;
use App\Validation\User\LoginValidation;

class LoginService
{
    private StockMarketUserRepository $repository;

    public function __construct()
    {
        $this->repository = new StockMarketUserRepository();
    }

    public function execute(string $email, string $password): ?User
    {
        $loginValidation = new LoginValidation($email, $password);
        if ($loginValidation->success())
        {
            return $this->repository->getUserByEmail($email);
        }
        return null;
    }
}