<?php
//composer require respect/validation
namespace App;

use App\Services\Register\RegisterService;
use Respect\Validation\Validator as v;

class RegistrationValidation
{
    public function validate(array $post): void
    {
        (new RegistrationValidation())->validatePassword($post);
        (new RegistrationValidation())->validateEmail($post);
    }

    private function validatePassword(array $post): void
    {
        if ($post['password'] != $post['password_repeat']) {
            $_SESSION['error']['password'] = 'Passwords do not match';
        }

        if (strlen($post['password']) < 8) {
            $_SESSION['error']['password'] = 'Password must contain at least 8 symbols';
        }

        if (!preg_match('~[0-9]+~', $post['password'])) {
            $_SESSION['error']['password'] = 'Password must contain numbers also';
        }
    }

    private function validateEmail(array $post): void
    {
        $registerService = new RegisterService();

        if ($registerService->checkEmail($post['email']) !== false) {
            $_SESSION['error']['email'] = 'Email is already being used';
        }

        if (v::email()->validate($post['email']) !== true) {
            $_SESSION['error']['email'] = 'Invalid email form';
        }
    }
}