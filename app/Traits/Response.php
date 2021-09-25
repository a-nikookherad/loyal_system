<?php

namespace App\Traits;

trait Response
{
    public function successResponse(string $message = "", array $data = [], int $code = 200)
    {
        return response()->json([
            "message" => __("messages.{$message}"),
            "data" => $data
        ], $code);
    }

    public function errorResponse(string $message = "", array $errors = [], int $code = 400)
    {
        return response()->json([
            "message" => __("messages.{$message}"),
            "errors" => $errors
        ], $code);
    }
}
