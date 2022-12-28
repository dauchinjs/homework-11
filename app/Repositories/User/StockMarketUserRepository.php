<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Services\Database;

class StockMarketUserRepository implements UserRepository
{
    public function storeUser(string $name, string $email, string $password): void
    {
        Database::getConnection()->insert('users', [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function getUserByEmail(string $email): User
    {
        $resultSet = Database::getConnection()->executeQuery(
            'SELECT * FROM users WHERE email=?', [
            $email]);
        $userData = $resultSet->fetchAssociative();

        return new User($userData['name'], $userData['email'], $userData['password'], $userData['id']);
    }

    public function getUserById(int $id): User
    {
        $resultSet = Database::getConnection()->executeQuery(
            'SELECT * FROM users WHERE id=?', [
            $id]);
        $userData = $resultSet->fetchAssociative();

        return new User($userData['name'], $userData['email'], $userData['password'], $userData['id']);
    }
}