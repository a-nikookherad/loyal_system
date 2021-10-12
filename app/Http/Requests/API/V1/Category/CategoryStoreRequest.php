<?php

namespace App\Http\Requests\API\V1\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Gate::allows("author") || \Auth::user()->roles->min("level") <= 10) {
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
            "slug" => "required",
            "title" => "nullable|max:65",
            "subtitle" => "nullable|max:100",
            "description" => "nullable|max:135",
            "parent_id" => "nullable|numeric",
        ];
    }
}
