<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
	    if ($exception instanceof TokenExpiredException)
	    {
	    	return response()->json(['error' => 'Token is Expired', 400]);
	    }
	
//	    if ($exception instanceof TokenInvalidException)
//	    {
//		    return response()->json(['error' => 'Token is Invalid', 400]);
//	    }
	
//	    if ($exception instanceof JWTException)
//	    {
//		    return response()->json(['error' => 'Problem with token', 400]);
//	    }
	
	    // the token is valid and we have found the user via the sub claim
	    return response()->json(compact('user'));
//        return parent::render($request, $exception);
    }
}
