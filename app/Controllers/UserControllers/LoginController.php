<?php

namespace App\Controllers\UserControllers;

use App\Models\User;
use App\Redirect;
use App\Services\Login\LoginService;
use App\Template;

class LoginController
{

    public function showForm(): Template
    {
        return new Template('login.twig');
    }

    public function execute(): Redirect
    {
        $loginService = new LoginService();
        $user = $loginService->execute($_POST['email'], $_POST['password']);

        if($user === null) {
            return new Redirect('/login');
        }
        $_SESSION['auth_id'] = $user->getId();

        return new Redirect('/');
    }
}
