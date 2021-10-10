<?php

namespace App\Http\Requests\API\V1\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
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
            "id" => "required|numeric|exists:addresses,id",
            "country" => "nullable|string",
            "state" => "nullable|string",
            "city" => "nullable|string",
            "address" => "nullable|string",
            "postal_code" => "nullable|string",
        ];
    }
}
