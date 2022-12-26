<?php

namespace App\ViewVariables;

use App\Services\User\UserService;

class AuthViewVariables implements ViewVariables
{
    public function getName(): string
    {
        return 'auth';
    }

    public function getValue(): array
    {
        if (!isset($_SESSION['auth_id'])) {
            return [];
        }

        $service = new UserService();
        $user = $service->getUserByID($_SESSION['auth_id']);

        return [
            'id' => $user['id'],
            'balance' => $user['balance'],
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password'],
        ];

    }
}