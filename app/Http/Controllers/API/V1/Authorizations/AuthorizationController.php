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

            $roleInstance->permissions()->sync($request->permissions_ids);

            return $this->successResponse(__("messages.permission_successfully_assigned"), [$roleInstance], 201);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function attach(AuthorizationAttachRequest $request, $role_id)
    {
        dd(2);
    }

    public function detach(AuthorizationDetachRequest $request, $role_id)
    {
        dd(3);
    }
}
