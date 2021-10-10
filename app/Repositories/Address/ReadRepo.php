<?php

namespace App\Repositories\Address;

use App\Models\Address;

class ReadRepo
{
    public function paginate($per_page = 10)
    {
        return Address::query()
            ->paginate($per_page);
    }

    public function find(int $id)
    {
        return Address::query()
            ->where("id", $id)
            ->first();
    }
}
