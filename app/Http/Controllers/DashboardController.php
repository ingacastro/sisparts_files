<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
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
    	$dashboard_stats = [
    		'daily_pcts' => [
    			'amount' => 4,
    			'expected' => 5,
    			'percentage' => 83,
    		],
    		'daily_items' => [
    			'amount' => 12,
    			'expected' => 20,
    			'percentage' => 54,
    		],
    		'monthly_pcts' => [
    			'amount' => 10,
    			'expected' => 15,
    			'percentage' => 83,
    		],
    		'monthly_items' => [
    			'amount' => 38,
    			'expected' => 65,
    			'percentage' => 54,
    		],
    		'pending_ppas' => 8,
    		'rejected_ppas' => 4,
    		'monthly_rejected_ppas' => 3,
    		'rejected_ppas_percentage' => 4,
    		'quotation_average_time' => 5.23
    	];

        return view('dashboard', compact('dashboard_stats'));
    }
}
