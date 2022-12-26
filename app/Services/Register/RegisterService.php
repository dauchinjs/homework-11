<?php

namespace App\Services\Register;

use App\Models\User;
use App\Repositories\User\StockMarketUserRepository;
use App\Validation\User\RegisterValidation;

class RegisterService
{
    private StockMarketUserRepository $repository;

    public function __construct()
    {
        $this->repository = new StockMarketUserRepository();
    }

    public function execute(string $name, string $email, string $password, string $passwordRepeat): ?User
    {
        $registerValidation = new RegisterValidation($email, $password, $passwordRepeat);
        if ($registerValidation->success())
        {
            $this->repository->storeUser($name, $email, $password);
        }
        return null;
    }
}