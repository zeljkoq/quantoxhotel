<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Controllers\Controller;

class ApiRegisterController extends Controller
{
	public function register(RegisterRequest $request)
	{
		$user = new User();
		$user->email = $request->email;
		$user->name = $request->name;
		$user->password = bcrypt($request->password);
		$user->save();
		$credentials = request(['email', 'password']);
		
		if (!$token = auth()->attempt($credentials)) {
			return response()->json([
				'error' => 'Unauthorized'
			], 401);
		}
		return response()->json([
			'token' => $token
		]);
	}
}
