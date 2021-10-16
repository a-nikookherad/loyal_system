<?php

namespace App\Http\Controllers\API\V1\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Comment\CommentStoreRequest;
use App\Http\Requests\API\V1\Comment\CommentUpdateRequest;
use App\Http\Resources\API\V1\Comment\CommentResourceCollection;
use App\Models\Comment;
use App\Models\Guest;
use Illuminate\Database\Eloquent\Builder;

class CommentController extends Controller
{
    public function index()
    {
        $commentCollection = Comment::query()
            ->where("status", \request("status"))
            ->paginate(\request("per_page") ?? 10);
        return $this->successResponse(__("messages.comments_list"), [new CommentResourceCollection($commentCollection)]);
    }

    public function store(CommentStoreRequest $request)
    {
        try {
            //comment data
            $commentData = $request->only([
                "show_name",
                "title",
                "description",
                "post_id",
                "parent_id",
            ]);

            //check form type
            if (\Auth::check()) {
                $commentData["user_id"] = \Auth::id();
            } else {
                //check user exists
                $guestData = $request->only([
                    "full_name",
                    "mobile",
                ]);
                $guestData["ip"] = $request->ip();
                $guestInstance = Guest::query()
                    ->firstOrCreate($request->only("email"), $guestData);
                $commentData["guest_id"] = $guestInstance->id;
            }

            //comment status
            $commentData["status"] = "pending";
            $commentInstance = Comment::query()
                ->create($commentData);

            return $this->successResponse(__("messages.comment_add_successfully"), [$commentInstance], 201);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function show($post_id)
    {
        $commentCollection = Comment::query()
            ->whereHas("commentable", function (Builder $builder) use ($post_id) {
                $builder->where("id", $post_id);
            })
            ->with(["likes", "prosConses"])
            ->get();
        dd($commentCollection->toArray());
    }

    public function update(CommentUpdateRequest $request, $id)
    {
        try {

        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function destroy($id)
    {
        //
    }
}
