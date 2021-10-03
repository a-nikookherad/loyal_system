<?php

namespace App\Repositories\role;

use App\Models\Role;

class ReadRepo
{
    public function all()
    {
        return Role::query()
            ->get();
    }

    public function detailsWithId($id)
    {
        return Role::query()
            ->where("id", $id)
            ->first();
    }

    public function detailsWithName($name)
    {
        return Role::query()
            ->where("name", $name)
            ->first();
    }
}
