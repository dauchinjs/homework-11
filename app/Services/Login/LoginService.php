<?php

namespace App\Services\Login;

use App\Services\Database;

class LoginService
{
    public function execute(LoginServiceRequest $request)
    {
        $result = Database::getConnection()->executeQuery(
            'SELECT id FROM `stock-api`.marketUsers WHERE email=?', [
            $request->getEmail()]);

        $id = $result->fetchAssociative();

        $result = Database::getConnection()->executeQuery(
            'SELECT password FROM `stock-api`.marketUsers WHERE id=?', [$id['id']]);
        $hash = $result->fetchAllAssociative();

        if (password_verify($request->getPassword(), $hash[0]['password'])) {
            return $id;
        }
        return false;
    }
}