<?php

namespace App\Http\Controllers\API\V1\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Post\PostStoreRequest;
use App\Http\Requests\API\V1\Post\PostUpdateRequest;
use App\Http\Resources\API\V1\Post\PostResource;
use App\Http\Resources\API\V1\Post\PostResourceCollection;
use App\Models\Post;

class PostController extends Controller
{

    public function index()
    {
        $postsCollection = Post::query()
            ->with(["category", "costs", "attachments", "tags"])
            ->withCount("views")
            ->paginate(\request("per_page") ?? 10);

        return $this->successResponse(__("messages.posts_list"), [new PostResourceCollection($postsCollection)]);
    }

    public function store(PostStoreRequest $request)
    {
        try {
            \DB::beginTransaction();
            //get data
            $postData = $request->only([
                "slug",
                "canonical",
                "title",
                "description",
                "subtitle",
                "summery",
                "content",
                "category_id",
                "author_id",
                "status",
                "visibility",
                "order",
                "extra",
                "published_at",
                "expired_at",
                "parent_id",
                "update_id",
            ]);
            $postData["extra"] = json_encode($postData["extra"]);

            //create post
            $postInstance = Post::query()
                ->create($postData);
            \DB::commit();

            return $this->successResponse(__("messages.post_created_successfully"), [new PostResource($postInstance)], 201);
        } catch (\Throwable $exception) {
            \DB::rollBack();
            throw($exception);
        }
    }

    public function show($id)
    {
        $postsInstance = Post::query()
            ->where("id", $id)
            ->with(["comments.likes", "category", "relates", "costs", "attachments", "rates", "tags", "metaTags", "hero"])
            ->withCount("views")
            ->first();

        return $this->successResponse(__("messages.posts_information"), [new PostResource($postsInstance)]);
    }

    public function update(PostUpdateRequest $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
