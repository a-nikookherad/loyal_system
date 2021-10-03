<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\LoginRequest;
use App\Http\Requests\API\V1\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Repositories\User\CreateRepo;
use App\Repositories\User\ReadRepo;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            \DB::beginTransaction();
            $userCreateRepository = new CreateRepo();
            $userInstance = $userCreateRepository->withRole($request->all(), $request->account_type ?? "member");
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
            return $this->errorResponse("something_went_wrong", [$exception->getMessage()]);
        }
        return $this->successResponse("register_successfully", $userInstance, 201);
    }

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

        //return token
        return $this->successResponse("credential_is_correct", [
            "token" => \Auth::user()->createToken($request->account_type ?? "member", ["view_post", "visitor"]),
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
