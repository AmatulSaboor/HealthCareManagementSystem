<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordComplexityRule implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/[A-Za-z]/', $value) && preg_match('/\d/', $value) && preg_match('/[^A-Za-z0-9]/', $value);
    }

    public function message()
    {
        return 'The password must contain at least one letter, one digit, and one special character.';
    }
}