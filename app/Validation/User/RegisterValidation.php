<?php

namespace App\Validation\User;

use App\Services\Database;

class RegisterValidation implements ValidationInterface
{
    private string $email;
    private string $password;
    private string $passwordRepeat;

    public function __construct(string $email, string $password, string $passwordRepeat)
    {
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
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
        if ($this->password != $this->passwordRepeat) {
            return false;
        }
        return true;
    }
    public function checkPasswordLength(): bool
    {
        if (strlen($this->password) < 8) {
            return false;
        }
        return true;
    }

    public function checkPasswordNumbers(): bool
    {
        if (!preg_match('~[0-9]+~', $this->password)) {
            return false;
        }
        return true;
    }
    public function success(): bool
    {
        if ($this->checkEmail()) {
            $_SESSION['error']['emailTaken'] = true;
        }
        if ($this->checkPassword() === false) {
            $_SESSION['error']['passwordsMatch'] = false;
        }
        if($this->checkPasswordLength() === false) {
            $_SESSION['error']['passwordsLength'] = false;
        }
        if($this->checkPasswordNumbers() === false) {
            $_SESSION['error']['passwordsNumbers'] = false;
        }

        if (empty($_SESSION['error'])) {
            return true;
        }
        return false;
    }
}