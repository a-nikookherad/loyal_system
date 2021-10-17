<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        //create super admin user
        $users = [
            [
                "user" => [
                    "name" => "admin",
                    "family" => "admin",
                    "national_number" => "1234567890",
                    "birthdate" => "1991-03-10",
                    "mobile" => "09375727006",
                    "email" => "super_admin@admin.com",
                    "password" => \Hash::make(123),
                ],
                "roles" => [
                    "super_admin"
                ],
            ],
            [
                "user" => [
                    "name" => "author",
                    "family" => "author",
                    "national_number" => "1234567890",
                    "birthdate" => "1991-03-10",
                    "mobile" => "09375727001",
                    "email" => "author@author.com",
                    "password" => \Hash::make(123),
                ],
                "roles" => [
                    "author"
                ],
            ],
        ];

        foreach ($users as $item) {
            //create user instance
            $userInstance = User::query()
                ->create($item["user"]);

            //get all roles for assign to user
            $roleCollection = Role::query()
                ->whereIn("name", $item["roles"])
                ->get();

            //iterate between roles collection
            $roleArray = [];
            foreach ($roleCollection as $roleInstance) {
                $roleArray[$roleInstance->id] = ["created_at" => $roleInstance->created_at, "updated_at" => $roleInstance->updated_at];
            }

            $userInstance->roles()->sync($roleArray);
        }

    }
}
