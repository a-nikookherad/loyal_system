<?php

namespace App\Http\Requests\API\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "nullable|string|max:150",
            "family" => "nullable|string|max:150",
            "email" => "nullable|email",
            "national_number" => "nullable|numeric",
            "birthdate" => "nullable|date",
            "login_type" => "nullable|in:password,otp",
            "password" => "nullable|max:150",
        ];
    }
}
