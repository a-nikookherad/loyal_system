<?php

namespace App\Exceptions;

use App\Exceptions\API\V1\AddressException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
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
        //render response for clients
        $this->renderable(function (Throwable $exception, \Illuminate\Http\Request $request) {
            /*
            |--------------------------------------------------------
            |+++++++++++++++++++ all api exception ++++++++++++++++++++
            |--------------------------------------------------------
            */
            if ($request->acceptsJson()) {
                /*==================== check exception type ====================*/
                if ($exception instanceof AccessDeniedHttpException) {
                    return response()->json([
                        "message" => __("messages.access_denied"),
                        "errors" => [
                            __("messages.you_dont_have_permission")
                        ]
                    ], 403);
                } elseif ($exception instanceof AuthenticationException) {
                    return response()->json([
                        "message" => __("messages.unAuthentication"),
                        "errors" => [
                            __("messages.you_are_not_logged_in")
                        ]
                    ], 401);
                }

                /*==================== normal exception response ====================*/
                /*                return response()->json([
                                    "message" => $exception->getMessage(),
                                    "errors" => [
                                        "file" => $exception->getFile(),
                                        "line" => $exception->getLine(),
                                        "status_code" => $exception->getcode(),
                                    ]
                                ], 500);*/

                //for debugging
                /*                if (env("APP_DEBUG")) {
                                    dd([
                                        "message" => $exception->getMessage(),
                                        "errors" => [
                                            "file" => $exception->getFile(),
                                            "line" => $exception->getLine(),
                                            "status_code" => $exception->getcode(),
                                        ]
                                    ]);
                                }*/
            }

            /*
            |--------------------------------------------------------
            |+++++++++++++++++++ all web exception ++++++++++++++++++++
            |--------------------------------------------------------
            */
//            return view("errors.500");

        });

        //report in laravel log file
        $this->reportable(function (Throwable $exception) {
            if (\request()->acceptsJson()) {
                Log::alert("Handler exception: " . $exception->getMessage(), [
                    "file:" => $exception->getFile(),
                    "line:" => $exception->getLine(),
                    "status_code:" => $exception->getCode(),
                ]);
            }
        });
    }
}
