<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create super admin user
        $users = [
            [
                "email" => "super_admin@admin.com",
                "password" => bcrypt(123),
                "roles" => [
                    "super_admin"
                ],
                "profiles" => [
                    "name" => "admin",
                    "family" => "admin",
                    "national_number" => "1234567890",
                    "birthdate" => now(),
                    "accounts" => [

                    ]
                ],
            ],
        ];

        foreach ($users as $user) {
            //create user instance
            $userInstance = User::query()
                ->create([
                    "email" => $user["email"],
                    "password" => $user["password"],
                ]);

            $roleInstance = Role::query()
                ->whereIn("id", $user["roles"])
                ->get();

            //create profile for user instance
            foreach ($user["profiles"] as $profile) {
                $profileInstance = new Profile();
                $profileInstance->name = $profile["name"];
                $profileInstance->family = $profile["family"];
                $profileInstance->national_number = $profile["national_number"];
                $profileInstance->birthdate = $profile["birthdate"];
                $profileInstance->user()->associate($userInstance);
                $profileInstance->save();

                //create account for profile instance
                foreach ($profile["accounts"] as $account) {
                    //todo create account for profile
                }
            }

        }

    }
}
