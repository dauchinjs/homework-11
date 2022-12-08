<?php

namespace App\Services\Register;

use App\Services\Database;

class RegisterService
{
    public function execute(RegisterServiceRequest $request): void
    {
        Database::getConnection()->insert('marketUsers', [
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
        ]);
    }

    public function checkEmail(string $email): bool
    {
        $emailInDB = Database::getConnection()->fetchAllKeyValue('SELECT id, email FROM `stock-api`.marketUsers');
        if (in_array($email, $emailInDB)) {
            return true;
        }
        return false;
    }
}