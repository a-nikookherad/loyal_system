<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ReadRepo
{
    public function paginate($with, $per_page = 10)
    {
        return User::query()
            ->when(!empty($with), function (Builder $builder) use ($with) {
                $builder->with($with);
            })
            ->paginate($per_page);
    }

    public function get($with = [])
    {

    }

    public function find($user_id)
    {
        return User::query()
            ->where("id", $user_id)
            ->first();
    }

    public function findWith(int $user_id, array $with = [])
    {
        return User::query()
            ->when(!empty($with), function (Builder $builder) use ($with) {
                return $builder->with($with);
            })
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

    public function findWithEmail($email)
    {
        return User::query()
            ->where("email", $email)
            ->first();
    }
}
