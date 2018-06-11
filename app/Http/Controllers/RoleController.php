<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getRoles()
    {
        $roles = Role::get()->toArray();
        return response()->json([
            'roles' => $roles,
        ]);
    }
}
