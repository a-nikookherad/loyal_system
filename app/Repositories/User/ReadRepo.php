<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ReadRepo
{
    public function getUserByCredentials($username)
    {
        return User::query()
            ->where(function (Builder $builder) use ($username) {
                $builder->where("email", $username)
                    ->orWhere("mobile", $username);
            })
            ->with(["profile.roles"])
            ->first();
    }

    public function getUserById($user_id)
    {
        return User::query()
            ->where("id", $user_id)
            ->first();
    }
}
