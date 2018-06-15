<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parties = Party::whereDate('updated_at', '>=', \Carbon\Carbon::today()->toDateString())
            ->get();

        return view('welcome')->with([
            'parties' => $parties,
        ]);
    }
}
