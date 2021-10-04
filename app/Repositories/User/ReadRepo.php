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

    public function find($user_id)
    {
        return User::query()
            ->where("id", $user_id)
            ->first();
    }

    public function findByMobile($mobile)
    {
        return User::query()
            ->where("mobile", $mobile)
            ->first();
    }

    public function getUserByCredentials($username)
    {
        return User::query()
            ->where("email", $username)
            ->orWhere("mobile", $username)
            ->first();
    }
}
