<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "family",
        "national_number",
        "birthdate",
        "user_id",
    ];

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

    public function hasRole($role)
    {
        $check=false;
        if (is_string($role)) {
            $check =  collect($this->role->name)->contains($role);
        }


        /*        if (!$check) {
                    $levelRole= Role::query()->where('name','=',$role)->first();

                    $levelUser = $this->role->type;

                    if ($levelUser < $levelRole->type) {
                        $check = true;
                    }
                }*/
        return $check;
    }
}
