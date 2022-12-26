<?php

namespace App\Validation\User;

interface ValidationInterface
{
    public function checkEmail();
    public function checkPassword();
    public function success();
}
