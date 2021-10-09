<?php

namespace App\Repositories\role;

use App\Models\Role;

class ReadRepo
{
    public function get()
    {
        return Role::query()
            ->get();
    }

    public function findWithId($id)
    {
        return Role::query()
            ->where("id", $id)
            ->first();
    }

    public function findWithName($name)
    {
        return Role::query()
            ->where("name", $name)
            ->first();
    }
}
