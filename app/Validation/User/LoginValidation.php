<?php

namespace App\Validation\User;

use App\Services\Database;

class LoginValidation implements ValidationInterface
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function checkEmail(): bool
    {
        $emailsInDatabase = Database::getConnection()->fetchAllKeyValue('SELECT id, email FROM users');
        if (in_array($this->email, $emailsInDatabase)) {
            return true;
        }
        return false;
    }

    public function checkPassword(): bool
    {
        $resultSet = Database::getConnection()->executeQuery(
            'SELECT password FROM users WHERE email=?', [
            $this->email]);
        $hash = $resultSet->fetchAllAssociative();

        if (password_verify($this->password, $hash[0]["password"])) {
            return true;
        }
        return false;
    }

    public function success(): bool
    {
        if (!$this->checkEmail() || !$this->checkPassword()) {
            $_SESSION['error']['userCredentials'] = false;
            return false;
        }
        return true;
    }
}