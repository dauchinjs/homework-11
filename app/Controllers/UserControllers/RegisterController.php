<?php

namespace App\Controllers\UserControllers;

use App\Models\User;
use App\Redirect;
use App\Services\Register\RegisterService;
use App\Template;

class RegisterController
{
    public function showForm(): Template
    {
        return new Template('register.twig');
    }

    public function execute(): Redirect
    {
        $registerService = new RegisterService();
        $user = $registerService->execute($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_repeat']);

        if($user === null) {
            return new Redirect('/register');
        }
        $_SESSION['auth_id'] = $user->getId();

        return new Redirect('/');
    }
}