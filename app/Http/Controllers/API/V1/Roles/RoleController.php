<?php

namespace App\Http\Controllers\API\V1\Roles;

use App\Exceptions\API\V1\RoleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Role\RoleStoreRequest;
use App\Http\Resources\API\V1\Role\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        //get all roles
        $roleCollection = Role::query()
            ->get();

        //decorate each role
        $roleResource = RoleResource::collection($roleCollection);

        return $this->successResponse(__("messages.list_of_roles"), [$roleResource]);
    }

    public function store(RoleStoreRequest $request)
    {
        try {
            //check role level
            if ($request->level <= 0) {
                throw new RoleException(__("messages.level_can_not_greater_than_0"), 400);
            }

            //create role
            $roleInstance = Role::query()
                ->create($request->only([
                    "title",
                    "name",
                    "level",
                ]));

            return $this->successResponse(__("messages.role_created_successfully"), [$roleInstance], 201);
        } catch (\Throwable $exception) {
            throw($exception);
        }
    }

    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        Role::query()
            ->where("id", $id)
            ->delete();
        return $this->successResponse(__("messages.role_successfully_deleted"), [], 204);
    }
}
