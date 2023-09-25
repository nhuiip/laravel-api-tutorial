<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
           
        });
    }

    // render method is used to return the response
    // when a particular exception occurs
    public function render($request, Throwable $e)
    {
        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return (new \App\Http\Controllers\Api\ApiController)->unauthorizedResponse();
        }
        if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return (new \App\Http\Controllers\Api\ApiController)->forbiddenResponse();
        }
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return (new \App\Http\Controllers\Api\ApiController)->notFoundResponse();
        }
        if ($e instanceof \Illuminate\Database\QueryException) {
            return (new \App\Http\Controllers\Api\ApiController)->errorResponse('Something went wrong', $e->getMessage(), 400);
        }
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            return (new \App\Http\Controllers\Api\ApiController)->errorResponse('Something went wrong', $e->getMessage(), 500);
        }
    }
}
