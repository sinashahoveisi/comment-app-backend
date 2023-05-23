<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'code',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function(NotFoundHttpException $e, $request){
            return response()->structure([], 404, 'notFound');
        });
        $this->renderable(function(TokenInvalidException $e, $request){
            return response()->structure([
                'token' => __('auth.invalidToken')
            ], 401, 'unauthorized');
        });
        $this->renderable(function(AccessDeniedHttpException $e, $request){
            return response()->structure([], 403, 'unauthorized');
        });
        $this->renderable(function (TokenExpiredException $e, $request) {
            return response()->structure([
                'token' => __('auth.expiredToken')
            ], 401, 'unauthorized');
        });

        $this->renderable(function (JWTException $e, $request) {
            return response()->structure([
                'token' => __('auth.invalidToken')
            ], 401, 'unauthorized');
        });
    }
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->structure($exception->errors(), $exception->status, $exception->status == 422 ? 'validationError' : 'serverError');
    }

}
