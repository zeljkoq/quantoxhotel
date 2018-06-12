<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function index()
    {

        return view('organization.index')->with([
            'currentUser' => auth()->user(),
        ]);
    }

    public function getUserData(Request $request)
    {
        return 123;
    }
}
