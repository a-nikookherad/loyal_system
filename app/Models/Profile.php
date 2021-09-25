<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, "addressable");
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, "profiles_roles", "profile_id", "role_id");
    }
}
