<?php

namespace App\Http\Requests\API\V1\Authorization;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationAssignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Gate::allows("super_admin")) {
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
            "permissions_ids"=>"required|array"
        ];
    }
}
