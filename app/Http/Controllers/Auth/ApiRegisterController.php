<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegistrationRequest;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ApiRegisterController
 * @package App\Http\Controllers\Auth
 */
class ApiRegisterController extends Controller
{
    /**
     * @param RegistrationRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegistrationRequest $request, User $user)
    {
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();


        if ($request->roles != null) {
            foreach ($request->roles as $role) {
                DB::table('users_roles')->insert([
                    'user_id' => $user->id,
                    'role_id' => $role,
                ]);
            }
            $roles = Role::whereIn('id', $request->roles)->get()->pluck('name')->toArray();
        } else {
            $roles = [];
        }


        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Please check your details'
            ], 401);
        }
        return response()->json([
            'token' => $token,
            'roles' => $roles,
        ]);
    }
}
