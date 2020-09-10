<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    
        if($exception instanceof ValidationException){
            return response()->json(["Errors" => $exception->validator->errors()], 400);
        }

        if($exception instanceof NotFoundHttpException){
            return response()->json(["Errors" => "The Specified URL Not found"], 404);
        }

        if($exception instanceof ModelNotFoundException){
            return response()->json(["Errors" => "The Specified ID Not found"], 404);
        }

        if($exception instanceof AuthorizationException){
            return response()->json(["Errors" => "The Specified token not found"], 403);
        }


        return response()->json(["Errors" => "Internal Server Error"], 500);
  
        
    }
}
