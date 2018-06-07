<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RouteResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
	/**
	 * Create a new AuthController instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('jwt', ['except' => ['login']]);
	}
	
	/**
	 * Get a JWT via given credentials.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login()
	{
		$credentials = request(['email', 'password']);
		
		if (! $token = auth()->attempt($credentials)) {
			return response()->json(['error' => 'Unauthorized'], 401);
		}
		
		JWTAuth::setToken($token);
		$user = new UserResource(JWTAuth::authenticate());

		return response()->json(compact('token', 'user'));
		
	}

	public function getRoutes()
    {
        $routes = auth()->user()->roles()->get()->pluck('name')->toArray();

//dd($roles);
//        $routesCollection = [
//            'party',
//            'songs',
//        ];

//        dd(array_search('dj', $roles));
//        dd(array_diff($routesCollection, $roles));
//        $routes = array_intersect_key($routesCollection, $roles);
        return response()->json(compact('routes'));
    }

	/**
	 * Get the authenticated User.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function me()
	{
		return response()->json(auth()->user());
	}
	
	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout()
	{
		auth()->logout();
		
		return response()->json(['message' => 'Successfully logged out']);
	}
	
	/**
	 * Refresh a token.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh()
	{
		return $this->respondWithToken(auth()->refresh());
	}
	
	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken($token)
	{
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth()->factory()->getTTL() * 60
		]);
	}
}
