<?php

namespace App\Http\Controllers\API\V1;

use App\Exceptions\API\LoginException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\DestroyUserRequest;
use App\Http\Requests\API\V1\LoginRequest;
use App\Http\Requests\API\V1\LogoutRequest;
use App\Http\Requests\API\V1\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use App\Repositories\User\CreateRepo;
use App\Repositories\User\DeleteRepo;
use App\Repositories\User\ReadRepo;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            \DB::beginTransaction();
            $userCreateRepository = new CreateRepo();
            $userInstance = $userCreateRepository->withRole($request->all(), "customer");
            \DB::commit();
            return $this->successResponse("user_registered_successfully", $userInstance->toArray(), 201);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return $this->errorResponse("something_went_wrong", [$exception->getMessage()]);
        }
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
                "accessToken" => \Auth::user()->createToken("customer")->accessToken,
                "user" => new LoginResource($userInstance)
            ]);

        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function logout(LogoutRequest $request)
    {
        $tokenId = getJti();

        $tokenRepository = app(TokenRepository::class);
//        $refreshTokenRepository = app(RefreshTokenRepository::class);

        // Revoke an access token...
        $tokenRepository->revokeAccessToken($tokenId);

        // Revoke all of the token's refresh tokens...
//        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($request);

        return $this->successResponse("you_are_logged_out_successfully");
    }

    public function destroy(DestroyUserRequest $request)
    {
        $userDeleteRepository = new DeleteRepo();
        $userDeleteRepository->destroyWithoutSuperAdmin($request->id);
        return $this->successResponse("user_delete_successfully", [], 204);
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
