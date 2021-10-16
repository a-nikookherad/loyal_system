<?php

namespace App\Http\Requests\API\V1\Comment;

use App\Rules\Mobile;
use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            "form_type" => "required|in:unauthorized,authorize",
            "full_name" => "nullable|max:200",
            "show_name" => "nullable|boolean",
            "email" => "required_unless:form_type,authorize|email",
            "mobile" => ["nullable", new Mobile],
            "post_id" => "bail|required|numeric|exists:posts,id",
            "title" => "nullable|max:150",
            "description" => "required|max:300|min:10",
            "strength" => "nullable|array",
            "weakness" => "nullable|array",
        ];
    }
}
