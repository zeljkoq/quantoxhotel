<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrganizationController extends Controller
{
	public function index()
	{
		
	
	
//		if (auth()->user())
//		{
//			if (auth()->user()->hasRole('party'))
//			{
				return view('organization.index')->with([
					'currentUser' => auth()->user(),
				]);
//			}
//			return redirect('/');
//		}
//		return redirect('/');
	}
}
