<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        //create application users roles
        $roles = [
            [
                "title" => "مدیر ارشد",
                "name" => "super_admin",
                "level" => "0",
            ],
            [
                "title" => "مدیر",
                "name" => "admin",
                "level" => "9",
            ],
            [
                "title" => "سرپرست",
                "name" => "supervisor",
                "level" => "10",
            ],
            [
                "title" => "نویسنده",
                "name" => "author",
                "level" => "100",
            ],
            [
                "title" => "عضو",
                "name" => "member",
                "level" => "1000",
            ],
            [
                "title" => "مشتری",
                "name" => "customer",
                "level" => "1000",
            ],
            [
                "title" => "میهمان",
                "name" => "guest",
                "level" => "10000",
            ],
        ];

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \DB::table("roles")->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        foreach ($roles as $role) {
            Role::query()
                ->create($role);
        }
    }
}
