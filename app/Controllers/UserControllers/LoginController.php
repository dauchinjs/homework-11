<?php

namespace App\Controllers\UserControllers;

use App\Redirect;
use App\Services\Login\LoginService;
use App\Services\Login\LoginServiceRequest;
use App\Template;

class LoginController
{

    public function showForm(): Template
    {
        return new Template('login.twig');
    }

    public function execute()
    {
        $loginService = new LoginService();
        $user = $loginService->execute(
            new LoginServiceRequest(
                $_POST['email'],
                $_POST['password'],
            ));

        if ($user === false) {
            return new Template('login.twig', ['credentials' => false]);
        }
        $_SESSION['auth_id'] = $user['id'];
        return new Redirect('/');
    }
}