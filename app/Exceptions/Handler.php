<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $exception, \Illuminate\Http\Request $request) {
            if ($request->acceptsJson()) {
                if ($exception instanceof AccessDeniedHttpException) {
                    return response()->json([
                        "message" => __("messages.access_denied"),
                        "errors" => [
                            __("messages.you_dont_have_permission")
                        ]
                    ], 403);
                }
                return response()->json([
                    "message" => __("messages.{$exception->getMessage()}"),
                    "errors" => [
                        $exception->getFile(),
                        $exception->getMessage(),
                        $exception->getCode(),
                    ]
                ]);
            }
        });

        $this->reportable(function (Throwable $e) {
            //
        });

    }
}
