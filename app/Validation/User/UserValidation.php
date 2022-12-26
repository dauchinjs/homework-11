<?php

namespace App\Validation\User;

use App\Services\Database;

class UserValidation
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function success(): bool
    {
        $result = Database::getConnection()->executeQuery(
            'SELECT id FROM users WHERE email = ?', [
            $this->email
        ]);
        $id = $result->fetchOne();
        if($id === false) {
            return false;
        }
        return true;
    }
}