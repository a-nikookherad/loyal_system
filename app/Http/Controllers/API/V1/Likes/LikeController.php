<?php

namespace App\Http\Controllers\API\V1\Likes;

use App\Exceptions\API\V1\LikeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Like\LikeStoreRequest;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function store(LikeStoreRequest $request)
    {
        dd(435);
        try {
            $ip = $request->ip();
            dd($ip);
            $identifierValue = "identifier_" . $ip;

            if (Cookie::has("__identifier")) {
                $identifier = Cookie::get("__identifier");
                $likeInstance = Like::query()
                    ->where("identify", $identifier)
                    ->orWhere("identify", $identifierValue)
                    ->first();

                //check user like before
                if ($likeInstance instanceof Like) {
                    $likeInstance->forceDelete();
                }
            } else {
                Cookie::forever("__identifier", $identifierValue);
            }

            //exec likeable
            $likeInstance = new Like();
            if ($request->like) {
                $likeInstance->name = "like";
                $likeInstance->identify = $identifierValue;
            }
            if ($request->dislike) {
                $likeInstance->name = "dislike";
                $likeInstance->identify = $identifierValue;
            }

            $likeInstance->save();

            return $this->successResponse(__("messages.successfully_operation"));
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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
}
