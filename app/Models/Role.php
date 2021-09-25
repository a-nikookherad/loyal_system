<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, "profiles_roles", "role_id", "profile_id");
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, "roles_permissions", "role_id", "permission_id")->withPivot(["expired_at"]);
    }
}
