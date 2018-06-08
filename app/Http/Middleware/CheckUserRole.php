<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$role = $request->route()->getAction()['role'];

    	
	    if (auth()->user()->hasRole($role))
	    {
		    return $next($request);
	    }
	    
    	

	    return response()->json(false);
	    
    }
}
