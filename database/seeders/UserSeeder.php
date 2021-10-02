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
                "name" => "admin",
                "family" => "admin",
                "national_number" => "1234567890",
                "birthdate" => "1991-03-10",
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
                ->create($user);

            //get all roles for assign to user
            $roleCollection = Role::query()
                ->whereIn("name", $user["roles"])
                ->get();

            //iterate between roles collection
            $roleArray = [];
            foreach ($roleCollection as $roleInstance) {
                array_push($roleArray, $roleInstance->id, ["created_at" => $roleInstance->created_at, "updated_at" => $roleInstance->updated_at]);
            }
            $userInstance->roles()->sync($roleArray);

            //create profile for user instance
            /*            foreach ($user["profiles"] as $profile) {
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
                        }*/

        }

    }
}
