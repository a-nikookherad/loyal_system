<?php

namespace App\Exceptions\API;

use Exception;

class LoginException extends Exception
{

    public function report()
    {
        \Log::info($this->getMessage() . " for username " . request("username"));
//        return false;
    }

    public function render($request)
    {
        return response()->json([
            "message" => __("messages.something_went_wrong"),
            "errors" => [
                $this->getMessage()
            ]
        ], $this->getCode());
//        $this->errorResponse("something_went_wrong", [$exception->getMessage()], $exception->getCode());
    }
}
