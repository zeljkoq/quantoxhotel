<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiRegisterController extends Controller
{
	public function register(RegistrationRequest $request, User $user)
	{
		$user->email = $request->emailRegister;
		$user->name = $request->nameRegister;
		$user->password = bcrypt($request->passwordRegister);
		$user->save();

		$credentials = request(['emailRegister', 'passwordRegister']);
		
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
