<?php

namespace App\Http\Controllers\API\V1\Users;

use App\Exceptions\API\V1\UserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\User\UserStoreRequest;
use App\Http\Requests\API\V1\User\UserUpdateRequest;
use App\Http\Resources\API\V1\User\UserResource;
use App\Http\Resources\API\V1\User\UserResourceCollection;
use App\Models\Role;
use App\Models\User;
use App\Repositories\User\CreateRepo;
use App\Repositories\User\ReadRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $userReadRepository = new ReadRepo();
        $usersCollection = $userReadRepository->paginate(null, \request("per_page") ?? 10);
        return $this->successResponse(__("messages.user_list"), [new UserResourceCollection($usersCollection)]);
    }

    public function store(UserStoreRequest $request)
    {
        try {
            \DB::beginTransaction();
            $userCreateRepository = new CreateRepo();
            $userInstance = $userCreateRepository->withRolesIds($request->all(), $request->roles_ids ?? ["guest"]);
            \DB::commit();
            return $this->successResponse(__("messages.user_created_successfully"), [new UserResource($userInstance)], 201);
        } catch (\Throwable $exception) {
            throw ($exception);
        }
    }

    public function show($id)
    {
        try {
            //validate id
            if (empty($id) && !is_integer($id) && $id <= 0) {
                throw new UserException(__("messages.input_id_is_invalid"), 400);
            }

            //find user
            $userReadRepository = new ReadRepo();
            $userInstance = $userReadRepository->find(\request("id"));

            //check user exist
            if (!$userInstance instanceof User) {
                throw new UserException(__("messages.user_is_not_exist"), 404);
            }

            return $this->successResponse(__("messages.user_information"), [new UserResource($userInstance)]);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            //validate id
            if (empty($id) && !is_integer($id) && $id <= 0) {
                throw new UserException(__("messages.input_id_is_invalid"), 400);
            }

            //find user
            $userReadRepository = new ReadRepo();
            $userInstance = $userReadRepository->find(\request("id"));

            //check user exist
            if (!$userInstance instanceof User) {
                throw new UserException(__("messages.user_is_not_exist"), 404);
            }

            //check is email Repetitious?
            if ($request->email != $userInstance->email) {
                $userConflict = $userReadRepository->findWithEmail($request->email);
                //check conflict with other emails
                if ($userConflict instanceof User) {
                    throw new UserException(__("messages.email_is_invalid"), 409);
                }
            }

            //update user
            $userInstance->family = $request->family ?? $userInstance->family;
            $userInstance->name = $request->name ?? $userInstance->name;
            $userInstance->national_number = $request->national_number ?? $userInstance->national_number;
            $userInstance->birthdate = $request->birthdate ?? $userInstance->birthdate;
            $userInstance->login_type = $request->login_type ?? $userInstance->login_type;
            $userInstance->password = !empty($request->password) ? Hash::make($request->password) : $userInstance->password;
            $userInstance->save();

            return $this->successResponse(__("messages.user_updated_successfully"), [$userInstance], 202);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function destroy($id)
    {
        try {
            //validate id
            if (empty($id) && !is_integer($id) && $id <= 0) {
                throw new UserException(__("messages.input_id_is_invalid"), 400);
            }

            //find user
            $userReadRepository = new ReadRepo();
            $userInstance = $userReadRepository->findWith(\request("id"), ["roles"]);

            //check user exist
            if (!$userInstance instanceof User) {
                throw new UserException(__("messages.user_is_not_exist"), 404);
            }

            //check user's role is not super admin
            if ($userInstance->roles->where("level", 0)->first() instanceof Role) {
                throw new UserException(__("messages.invalid_action"), 403);
            }

            //delete user
            $userInstance->delete();

            //return success response
            return $this->successResponse(__("messages.user_delete_successfully"), [], 204);
        } catch (\Throwable $exception) {
            throw($exception);
        }

    }
}
