<?php

namespace App\Controllers\UserControllers;

use App\Template;

class ProfileController
{
    public function showForm(): Template
    {
        return new Template('profile.twig');
    }
}