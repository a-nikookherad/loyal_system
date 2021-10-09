<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class DeleteRepo
{
    public function destroy($id)
    {
        //user delete
        return User::query()
            ->where("id", $id)
            ->delete();
    }

    public function destroyWithoutSuperAdmin($id)
    {
        //user delete
        return User::query()
            ->where("id", $id)
            ->whereHas("roles", function (Builder $builder) {
                $builder->where("name", "!=", "super_admin");
            })
            ->delete();
    }

    public function withProfile($id)
    {
        $this->destroy($id);
    }
}
