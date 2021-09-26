<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "name",
        "method",
        "active",
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, "roles_permissions", "permission_id", "role_id");
    }
}
