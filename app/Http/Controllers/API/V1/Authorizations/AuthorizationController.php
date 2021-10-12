<?php

namespace App\Http\Controllers\API\V1\Authorizations;

use App\Exceptions\API\V1\AuthorizationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Authorization\AuthorizationAssignRequest;
use App\Http\Requests\API\V1\Authorization\AuthorizationAttachRequest;
use App\Http\Requests\API\V1\Authorization\AuthorizationDetachRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function assign(AuthorizationAssignRequest $request, $role_id)
    {
        try {
            //get role instance
            $roleInstance = Role::query()
                ->where("id", $role_id)
                ->first();

            //check role exist
            if (!$roleInstance instanceof Role) {
                throw new AuthorizationException(__("messages.role_not_exist"), 404);
            }

            //make permission database format
            $permissions = $this->getPermissions($request->permissions_ids);

            //assign permissions to role
            $roleInstance->permissions()->sync($permissions);

            return $this->successResponse(__("messages.permission_successfully_assigned"), [$roleInstance], 201);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function attach(AuthorizationAttachRequest $request, $role_id)
    {
        try {
            //get role instance
            $roleInstance = Role::query()
                ->where("id", $role_id)
                ->first();

            //check role exist
            if (!$roleInstance instanceof Role) {
                throw new AuthorizationException(__("messages.role_not_exist"), 404);
            }

            //make permission database format
            $permissions = $this->getPermissions($request->permissions_ids);

            //attach permissions to role
            $roleInstance->permissions()->attach($permissions);

            return $this->successResponse(__("messages.permission_successfully_attached"), [$roleInstance], 201);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function detach(AuthorizationDetachRequest $request, $role_id)
    {
        try {
            //get role instance
            $roleInstance = Role::query()
                ->where("id", $role_id)
                ->first();

            //check role exist
            if (!$roleInstance instanceof Role) {
                throw new AuthorizationException(__("messages.role_not_exist"), 404);
            }

            //detach permissions from role
            $roleInstance->permissions()->detach($request->permissions_ids);

            return $this->successResponse(__("messages.permission_successfully_detached"), [$roleInstance], 201);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }


    protected function getPermissions($permissions_ids): array
    {
        $permissions = [];
        foreach ($permissions_ids as $permissions_id) {
            $permissions[$permissions_id] = [
                "expired_at" => null,
                "created_at" => date("Y-m-d H:i:s", strtotime(now())),
                "updated_at" => date("Y-m-d H:i:s", strtotime(now())),
            ];
        }
        return $permissions;
    }
}
