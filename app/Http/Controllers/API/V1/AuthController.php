<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Repositories\User\ReadRepo;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        //get user with username
        $usersReadRepository = new ReadRepo();
        $data = $request->only(["username", "password"]);
        $userInstance = $usersReadRepository->getUserByCredentials($data["username"]);

        //check credentials
        if (!\Hash::check($data["password"], $userInstance->password)) {
            //if authentication is false
            return $this->errorResponse("credential_is_wrong", null, 401);
        }


        return $this->successResponse("credential_is_correct", [
            "token" => \Auth::user()->createToken("member", ["view_post", "visitor"]),
            "user" => new LoginResource($userInstance->profile)
        ]);
    }

    public function logout()
    {
        //
    }


    public function refresh_token()
    {
        //
    }

    public function reset_password()
    {
        //
    }
}
