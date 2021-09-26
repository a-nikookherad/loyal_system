<?php

namespace App\Repositories\User;

use App\Models\Profile;
use App\Models\User;

class CreateRepo
{
    //create raw user
    public function create($data)
    {
        return User::query()
            ->create($data);
    }

    public function withProfile($data)
    {
        try {
            \DB::beginTransaction();

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

            \DB::commit();

            return [$userInstance, $profileInstance];
        } catch (\Exception $exception) {
            \DB::rollBack();
            return false;
        }
    }

    public function withProfileAndAccount($data)
    {
        try {
            \DB::beginTransaction();

            //create user instance
            list($userInstance, $profileInstance) = $this->withProfile($data);

            //create account instance
            //todo create instance of account for profile

            \DB::commit();

            return [$userInstance, $profileInstance];
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw($exception);
        }
    }
}
