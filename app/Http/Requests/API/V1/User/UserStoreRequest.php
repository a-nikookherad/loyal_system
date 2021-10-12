<?php

namespace App\Http\Requests\API\V1\User;

use App\Rules\Mobile;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::user()->roles->min("level") < 10) {
            return true;
        }
        return false;
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
            "mobile" => ["nullable", "unique:users,mobile", new Mobile],
            "email" => "required_without:mobile|required_unless:mobile,null|email|unique:users,email",
            "national_number" => "nullable|numeric",
            "birthdate" => "nullable|date",
            "login_type" => "nullable|in:password,otp",
            "password" => "required|max:150",
            "roles_ids" => "nullable|array",
        ];
    }
}
