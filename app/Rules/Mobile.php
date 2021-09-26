<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Mobile implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match("/(0|98|0098|\+98)(9)[0-9]{9}/", $value);
    }

    public function message()
    {
        return __("validation.mobile");
    }
}
