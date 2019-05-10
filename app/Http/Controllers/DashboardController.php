<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Document;
use IParts\SupplySet;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
        $this->daily_pcts = 5;
        $this->daily_items = 20;
        $this->monthly_pcts = 15;
        $this->monthly_items  = 65;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now = Carbon::now();

        $daily_ctz_pcts = Document::where('status', 3)
        ->whereDate('completed_date', '=', $now->toDateString())->count();

        $daily_ctz_items = SupplySet::where('status', 9)
        ->whereDate('completed_date', '=', $now->toDateString())->count();

        $monthly_ctz_pcts = Document::where('status', 3)
        ->whereMonth('completed_date', '=', $now->month)->count();

        $monthly_ctz_items = SupplySet::where('status', 9)
        ->whereMonth('completed_date', '=', $now->month)->count();
        
        Log::notice($now->month);

    	$dashboard_stats = [
    		'daily_pcts' => [
    			'amount' => $daily_ctz_pcts,
    			'expected' => $this->daily_pcts,
    			'percentage' => number_format(($daily_ctz_pcts / 5) * 100, 2),
    		],
    		'daily_items' => [
    			'amount' => $daily_ctz_items,
    			'expected' => $this->daily_items,
    			'percentage' => number_format(($daily_ctz_items / 20) * 100, 2),
    		],
    		'monthly_pcts' => [
    			'amount' => $monthly_ctz_pcts,
    			'expected' => $this->monthly_pcts,
    			'percentage' => number_format(($monthly_ctz_pcts / 15) * 100, 2),
    		],
    		'monthly_items' => [
    			'amount' => $monthly_ctz_items,
    			'expected' => $this->monthly_items,
    			'percentage' => number_format(($monthly_ctz_items / 65) * 100, 2),
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
