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
        $roles = \Auth::user()->roles;
        $role = $roles->where("level", $roles->min("level"))->first();

        // get user role permissions
        $permissions = $role->permissions;

        // get requested action
        $actionName = class_basename($request->route()->getActionname());

        // check if requested action is in permissions list
        foreach ($permissions as $permission) {
            $_namespaces_chunks = explode("\\", $permission->controller);
            $controller = end($_namespaces_chunks);
            if (($actionName == $controller . "@" . $permission->method) && ($permission->name == $request->route()->getName())) {
                // authorized request
                return $next($request);
            }
        }

        // none authorized request
        if ($request->acceptsJson()) {
            return response()
                ->json([
                    "message" => __("messages.access_denied"),
                    "errors" => __("messages.you_dont_have_permission"),
                ], 403);
        }
        return view("errors.403");
    }
}
