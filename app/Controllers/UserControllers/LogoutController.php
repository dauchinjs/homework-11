<?php

namespace App\Controllers\UserControllers;

use App\Redirect;

class LogoutController
{
    public function exit(): Redirect
    {
        session_unset();
        return new Redirect("/");
    }

}