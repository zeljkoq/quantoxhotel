<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserInfo($user_id)
    {
        $user = User::where('id', $user_id)->first();
        return $user;
    }
}
