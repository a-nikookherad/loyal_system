<?php

namespace App\Repositories\User;

class DeleteRepo
{
    public function destroy($id)
    {
        //user
    }

    public function withProfile($id)
    {
        $this->destroy($id);
    }
}
