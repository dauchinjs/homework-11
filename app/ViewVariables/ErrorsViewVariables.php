<?php

namespace App\ViewVariables;

class ErrorsViewVariables implements ViewVariables
{
    public function getName(): string
    {
        return 'error';
    }

    public function getValue(): array
    {
        return $_SESSION['error'] ?? [];
    }
}