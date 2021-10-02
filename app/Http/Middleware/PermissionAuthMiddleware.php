<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //get current user roles
//        $role = Role::findOrFail(auth()->user()->role_id);
        $roles = \Auth::user()->roles;
        $role = $roles->max("level")->first();

        // get user role permissions
        $permissions = $role->permissions;

        // get requested action
        $actionName = class_basename($request->route()->getActionname());

        // check if requested action is in permissions list
        foreach ($permissions as $permission) {
            $_namespaces_chunks = explode("\\", $permission->controller);
            $controller = end($_namespaces_chunks);
            if ($actionName == $controller . "@" . $permission->method) {
                // authorized request
                return $next($request);
            }
        }

        // none authorized request
        return response()
            ->json([
                "message" => "Unauthorized Action",
                "errors" => "Unauthorized Action",
            ], 403);
    }
}
