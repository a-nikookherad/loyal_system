<?php

namespace App\Http\Requests\API\V1;

use App\Rules\Mobile;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => "nullable|string|min:2|max:50",
            "family" => "nullable|string|min:2|max:80",
            "mobile" => ["nullable", new Mobile(), "unique:users,mobile"],
            "email" => "required_without:mobile|unique:users,email",
            "password" => "required",
        ];
    }
}
