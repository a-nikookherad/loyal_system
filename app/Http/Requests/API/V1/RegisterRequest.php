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
            "name" => "nullable|persian_alpha",
            "family" => "nullable|persian_alpha",
            "mobile" => ["nullable", new Mobile()],
            "email" => "required_unless:mobile,null",
            "password" => "required",
        ];
    }
}
