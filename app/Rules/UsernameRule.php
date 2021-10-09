<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UsernameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (preg_match("/^[a-zA-Z0-9_.]{3,}\@[a-zA-Z]+\.[a-zA-Z]+$/", $value)) {
            return true;
        } elseif (preg_match("/(0|98|0098|\+98)(9)[0-9]{9}/", $value)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("validation.username_format_is_not_correct");
    }
}
