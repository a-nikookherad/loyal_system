<?php

namespace App\Exceptions\API\V1;

use App\Traits\Response;
use Exception;
use Illuminate\Support\Facades\Log;

class AddressException extends Exception
{
    use Response;

    public function report()
    {
        Log::info($this->getMessage() . " ======> ", [
            "file:" => $this->getFile(),
            "line:" => $this->getLine(),
            "status_code:" => $this->getCode(),
        ]);
    }

    public function render($request)
    {
        return $this->errorResponse($this->getMessage(), [
            $this->getFile(),
            $this->getLine(),
        ], $this->getCode());
    }
}
