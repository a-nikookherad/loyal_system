<?php

namespace App\Http\Requests\API\V1\Like;

use Illuminate\Foundation\Http\FormRequest;

class LikeStoreRequest extends FormRequest
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
            "comment_id" => "required",
            "like" => "nullable|boolean",
            "dislike" => "required_without:like|nullable|boolean|different:like",
        ];
    }
}
