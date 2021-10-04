<?php

namespace App\Repositories\User;

use App\Models\Profile;
use App\Models\User;
use App\Repositories\role\ReadRepo;

class CreateRepo
{
    //create raw user
    public function create($data)
    {
        return User::query()
            ->create($data);
    }

    public function withRole($data, $role = "guest")
    {
        //create user instance
        $userInstance = User::query()
            ->create($data);

        //get role for assign to user instance
        $roleRepo = new ReadRepo();
        $roleInstance = $roleRepo->findWithName($role);
        $userInstance->roles()->attach($roleInstance->id);

        return $userInstance;
    }

    public function withProfile($data)
    {
        //create user instance
        $userInstance = $this->create($data);
        if (!$userInstance instanceof User) {
            throw new \Exception("user not created");
        }

        //create profile instacne
        $data["user_id"] = $userInstance->id;
        $profileInstance = Profile::query()
            ->create($data);
        if (!$profileInstance instanceof Profile) {
            throw new \Exception("profile not created");
        }

        return [$userInstance, $profileInstance];
    }

    public function withProfileAndAccount($data)
    {
        //create user instance
        list($userInstance, $profileInstance) = $this->withProfile($data);

        //create account instance
        //todo create instance of account for profile

        return [$userInstance, $profileInstance];
    }
}
