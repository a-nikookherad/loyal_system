<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\API\LoginException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\LoginRequest;
use App\Http\Requests\API\V1\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use App\Repositories\User\CreateRepo;
use App\Repositories\User\ReadRepo;
use function PHPUnit\Framework\throwException;

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
        try {
            //get user with username
            $usersReadRepository = new ReadRepo();
            $data = $request->only(["username", "password"]);
            $userInstance = $usersReadRepository->getUserByCredentials($data["username"]);

            //check user exists
            if (!$userInstance instanceof User) {
                throw new LoginException(__("messages.user_is_not_exist"), 404);
            }

            //check credentials
            if (!\Hash::check($data["password"], $userInstance->password)) {
                //if authentication is false
                throw new LoginException(__("messages.credential_is_wrong"), 401);
            }

            //login user
            \Auth::login($userInstance, $request->remember ?? false);

            //return token
            return $this->successResponse("credential_is_corrected", [
                "token" => \Auth::user()->createToken("customer", ["view_post", "visitor", "view_products"])->toArray(),
                "user" => new LoginResource($userInstance->profiles())
            ]);

        } catch (\Throwable $exception) {
            throw($exception);
        }
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
