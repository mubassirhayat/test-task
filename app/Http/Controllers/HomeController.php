<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Date;
use App\Services\TimezoneService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $timezone = new TimezoneService();
        $userTimezone = $timezone->getTimeZoneFromIpAddress();
        $dates = Date::paginate(20);
        return view('home', [
            'dates' => $dates,
            'userTimezone' => $userTimezone,
        ]);
    }
}
