<?php

namespace App\Http\Controllers\API\V1\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Permission\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index()
    {
        //get all roles
        $permissionCollection = Permission::query()
            ->where("active", true)
            ->get();

        //decorate each permission
        $permissionResource = PermissionResource::collection($permissionCollection);

        return $this->successResponse(__("messages.list_of_permissions"), [$permissionResource]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
