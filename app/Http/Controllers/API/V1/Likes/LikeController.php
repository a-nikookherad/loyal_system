<?php

namespace App\Http\Controllers\API\V1\Likes;

use App\Exceptions\API\V1\LikeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Like\LikeStoreRequest;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LikeController extends Controller
{
    public function index()
    {
        //
    }

    public function store(LikeStoreRequest $request)
    {
        try {
            //get comment id
            $commentInstance = Comment::query()
                ->where("id", $request->comment_id)
                ->first();

            //exec likeable
            $likeInstance = new Like();
            if (!empty($request->like)) {
                $likeInstance->name = "like";
                $newCookie = $this->getNewCookie($likeInstance, $request, "like");
            }

            if (!empty($request->dislike)) {
                $likeInstance->name = "dislike";
                $newCookie = $this->getNewCookie($likeInstance, $request, "dislike");
            }

            $commentInstance->likes()->save($likeInstance);

            if (!empty($newCookie)) {
                return $this->successResponse(__("messages.successfully_operation"))->withCookie($newCookie);
            }
            return $this->successResponse(__("messages.successfully_operation"));
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getNewCookie(Like $likeInstance, LikeStoreRequest $request, $type)
    {
        if (\Auth::guard("api")->check()) {
            $user_id = \Auth::guard("api")->id();
            $checkLikeInstance = Like::query()
                ->where("user_id", $user_id)
                ->where("name", $type)
                ->first();
            //check user like before
            if ($checkLikeInstance instanceof Like) {
                throw new LikeException(__("messages.you_{$type}_this_comment_before"), 409);
            }
            $likeInstance->user_id = $user_id;
        } else {
            $identifierValue = getIdentifier();
            $oldCookie = $request->cookie("__identifier");
            if (!empty($oldCookie)) {
                throw new LikeException(__("messages.you_{$type}_this_comment_before"), 409);
            } else {
                $checkLikeInstance = Like::query()
                    ->where("identify", $identifierValue)
                    ->where("name", $type)
                    ->first();

                //check user like before
                if ($checkLikeInstance instanceof Like) {
                    throw new LikeException(__("messages.you_{$type}_this_comment_before"), 409);
                }
                $newCookie = Cookie::make("__identifier", $identifierValue, now()->addMonth()->timestamp);
            }

            $likeInstance->identify = $identifierValue;
            return $newCookie;
        }
    }
}
