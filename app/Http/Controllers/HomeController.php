<?php

namespace App\Http\Controllers;

use App\Resident;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $residents = Resident::where('facility', \Auth::user()->facility);
        $credits = Resident::where('residents.facility', \Auth::user()->facility)
            ->join('transactions', 'residents.id', '=', 'transactions.resident_id')
            ->pluck('transactions.credit')->sum();
        $debits  = Resident::where('residents.facility', \Auth::user()->facility)
            ->join('transactions', 'residents.id', '=', 'transactions.resident_id')
            ->pluck('transactions.debit')->sum();

        $balance = ($credits - $debits) / 100;

        return view('home', compact('balance', 'residents'));
    }
}
