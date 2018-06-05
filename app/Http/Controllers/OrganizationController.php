<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizationController extends Controller
{
	public function index()
	{
		if (auth()->user())
		{
			if (auth()->user()->hasRole('party'))
			{
				return view('organization.index')->with([
					'currentUser' => auth()->user(),
				]);
			}
			return redirect('/');
		}
		return redirect('/');
	}
}
