<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        if (env("APP_ENV") == "local") {
            \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
            \DB::table("permissions")->truncate();
            \DB::table("roles_permissions")->truncate();
            \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        }

        $permission_ids = []; // an empty array of stored permission IDs
        // iterate though all routes
        foreach (Route::getRoutes()->getRoutes() as $key => $route) {
            //get route middlewares
            $middlewares = $route->middleware();

            //skip from public routes
            if (!(in_array("auth:api", $middlewares) || in_array("auth:web", $middlewares))) {
                continue;
            }

            // get route action
            $action = $route->getActionname();

            // separating controller and method
            $_action = explode("@", $action);

            $controller = $_action[0];
            $method = end($_action);

            // check if this permission is already exists
            $permissionInstance = Permission::query()
                ->where(
                    ["controller" => $controller, "method" => $method, "name" => $route->getName()]
                )->first();
            if (!$permissionInstance instanceof Permission) {
                $permission = new Permission;
                $permission->name = $route->getName();
                $permission->controller = $controller;
                $permission->method = $method;
                $permission->save();

                // add stored permission id in array
                $permission_ids[] = $permission->id;
            }
        }

        // find admin role.
        $adminRoleInstance = Role::query()
            ->where("name", "super_admin")
            ->first();

        // attache all permissions to admin role
        $adminRoleInstance->permissions()->sync($permission_ids);
    }
}
