<?php

namespace App\Repositories\Role;

use App\Models\Role;

class ReadRepo
{
    public function get()
    {
        return Role::query()
            ->where("level", "!=", 0)
            ->get();
    }

    public function findWithId($id)
    {
        return Role::query()
            ->where("id", $id)
            ->where("level", "!=", 0)
            ->first();
    }

    public function findWithName($name)
    {
        return Role::query()
            ->where("name", $name)
            ->where("level", "!=", 0)
            ->first();
    }

    public function findWithNames(array $names)
    {
        return Role::query()
            ->whereIn("name", $names)
            ->where("level", "!=", 0)
            ->get();
    }

    public function findWithIds(array $ids)
    {
        return Role::query()
            ->whereIn("id", $ids)
            ->where("level", "!=", 0)
            ->get();
    }
}
