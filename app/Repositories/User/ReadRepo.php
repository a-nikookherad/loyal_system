<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ReadRepo
{
    public function get($with = [])
    {
        return User::query()
            ->when(!empty($with), function (Builder $builder) use ($with) {
                $builder->with($with);
            })
            ->get();
    }

    public function getUserByCredentials($username)
    {
        return User::query()
            ->where(function (Builder $builder) use ($username) {
                $builder->where("email", $username)
                    ->orWhere("mobile", $username);
            })
            ->first();
    }

    public function getUserById($user_id)
    {
        return User::query()
            ->where("id", $user_id)
            ->first();
    }
}
