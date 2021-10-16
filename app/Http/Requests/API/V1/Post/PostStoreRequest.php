<?php

namespace App\Http\Requests\API\V1\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Gate::allows("author")|| \Auth::user()->roles->min("level") <= 10) {
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
            "canonical" => "nullable",
            "title" => "required|max:65",
            "description" => "required|max:135",
            "subtitle" => "nullable",
            "summery" => "nullable|string",
            "content" => "required",
            "category_id" => "nullable|numeric",
            "author_id" => "nullable|numeric",
            "parent_id" => "nullable|numeric",
            "update_id" => "nullable|numeric",
            "status" => "nullable|in:draft,in_review,ready,published",
            "visibility" => "nullable|in:private,public",
            "order" => "nullable|numeric",
            "extra" => "nullable",
            "published_at" => "nullable|date_format:Y-m-d H:i:s",
            "expired_at" => "nullable|date_format:Y-m-d H:i:s",
        ];
    }
}
