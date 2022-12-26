<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepository
{
    public function storeUser(string $name, string $email, string $password): void;
    public function getUserByEmail(string $email): User;
    public function getUserById(int $id): User;
}