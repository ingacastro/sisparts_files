<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\Document;
use IParts\SupplySet;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Auth;
use DB;
use Storage;
use IParts\User;

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
    public function index(Request $request)
    {
        $dealerships_pairs = User::role('Cotizador')->pluck('name', 'id');
        $dealerships_count = $dealerships_pairs->count();
        $dealerships_pairs->prepend('TODOS', 0);
        $dashboard_stats = $this->getUserStats($request, null, $dealerships_count);
        return view('dashboard', compact('dashboard_stats', 'dealerships_pairs'));
    }

    public function getUserStats(Request $request, $user_id, $dealerships_count = null)
    {
        $user = isset($user_id) && $user_id != 0 ? User::find($user_id) : Auth::user();
        $now = Carbon::now();
        $dealership = $user->hasRole('Cotizador') ? $user : null;

        $completed_pcts_base_query = Document::where('status', 3);
        $ctz_pcts_average_time_base_query = clone $completed_pcts_base_query;

        //PCTs
        $daily_ctz_pcts_base_query = $completed_pcts_base_query
        ->whereDate('completed_date', '=', $now->toDateString());

        $daily_ctz_items_base_query = SupplySet::where('documents_supplies.status', 9)
        ->whereDate('documents_supplies.completed_date', '=', $now->toDateString());

        $monthly_ctz_pcts_base_query = $completed_pcts_base_query
        ->whereMonth('completed_date', '=', $now->month);

        $monthly_ctz_items_base_query = SupplySet::where('documents_supplies.status', 9)
        ->whereMonth('documents_supplies.completed_date', '=', $now->month);

        //PPAs
        $pending_ppas_base_query = SupplySet::where('documents_supplies.status', 1);
        $rejected_ppas_base_query = SupplySet::where('documents_supplies.status', 7);
        $monthly_rejected_ppas_base_query = SupplySet::where('documents_supplies.status', 7)
        ->whereMonth('documents_supplies.rejected_date', '=', $now->month);

        //Quotation average time
        $ctz_pcts_average_time_base_query = $ctz_pcts_average_time_base_query
        ->select(DB::raw('SUM(DATEDIFF(documents.completed_date, documents.created_at)) / COUNT(*) as average_time'));

        if(isset($dealership)) {
            $dealership_id = $user->id;
            $daily_ctz_pcts_base_query->where('employees_users_id', $dealership_id);
            $daily_ctz_items_base_query->join('documents', 'documents.id', 'documents_supplies.documents_id')
            ->where('documents.employees_users_id', $dealership_id);
            $monthly_ctz_pcts_base_query->where('employees_users_id', $dealership_id);
            $monthly_ctz_items_base_query->join('documents', 'documents.id', 'documents_supplies.documents_id')
            ->where('documents.employees_users_id', $dealership_id);
            $pending_ppas_base_query->join('documents', 'documents.id', 'documents_supplies.documents_id')
            ->where('documents.employees_users_id', $dealership_id);
            $rejected_ppas_base_query->join('documents', 'documents.id', 'documents_supplies.documents_id')
            ->where('documents.employees_users_id', $dealership_id);
            $monthly_rejected_ppas_base_query->join('documents', 'documents.id', 'documents_supplies.documents_id')
            ->where('documents.employees_users_id', $dealership_id);
            $ctz_pcts_average_time_base_query->where('documents.employees_users_id', $dealership_id);
        }

        $result = [
            'daily_ctz_pcts' => $daily_ctz_pcts_base_query->count(),
            'daily_ctz_items' => $daily_ctz_items_base_query->count(),
            'monthly_ctz_pcts' => $monthly_ctz_pcts_base_query->count(),
            'monthly_ctz_items' => $monthly_ctz_items_base_query->count(),
            'pending_ppas' => $pending_ppas_base_query->count(),
            'rejected_ppas' => $rejected_ppas_base_query->count(),
            'monthly_rejected_ppas' => $monthly_rejected_ppas_base_query->count(),
            'ctz_pcts_average_time' => number_format($ctz_pcts_average_time_base_query->first()->average_time, 2)
        ];

        $is_ajax = $request->ajax();
        $result = $this->calculateStats($result, $user, $is_ajax, $dealerships_count);

        if(!$is_ajax) return $result;

        return response()->json($result);
    }

    private function calculateStats($stats, User $user, $is_ajax, $dealerships_count)
    {
        if($is_ajax) $dealerships_count = User::role('Cotizador')->count();

        $is_admin = $user->hasRole('Administrador');
        
        $daily_pcts = $is_admin ?  $dealerships_count * 5 : 5;
        $daily_items = $is_admin ? $dealerships_count * 20 : 20;
        $monthly = $daily_pcts * $this->getBusinessDays();
        $monthly_items  = $daily_items * $this->getBusinessDays();

        $supply_sets_amount = SupplySet::count();
        $rejected_ppas_percentage = ($supply_sets_amount > 0) ? $stats['rejected_ppas'] / $supply_sets_amount : $stats['rejected_ppas'];

        return [
            'daily_pcts' => [
                'amount' => $stats['daily_ctz_pcts'],
                /*'expected' => $daily_pcts,*/
                'percentage' => $daily_pcts == 0 ? 0 : number_format(($stats['daily_ctz_pcts'] / $daily_pcts) * 100, 2),
            ],
            'daily_items' => [
                'amount' => $stats['daily_ctz_items'],
                /*'expected' => $daily_items,*/
                'percentage' => $daily_items == 0 ? 0 : number_format(($stats['daily_ctz_items'] / $daily_items) * 100, 2),
            ],
            'monthly_pcts' => [
                'amount' => $stats['monthly_ctz_pcts'],
                /*'expected' => $monthly,*/
                'percentage' => $monthly == 0 ? 0 : number_format(($stats['monthly_ctz_pcts'] / $monthly) * 100, 2),
            ],
            'monthly_items' => [
                'amount' => $stats['monthly_ctz_items'],
                /*'expected' => $monthly_items,*/
                'percentage' => $monthly_items == 0 ? 0 : number_format(($stats['monthly_ctz_items'] / $monthly_items) * 100, 2),
            ],
            'pending_ppas' => $stats['pending_ppas'],
            'rejected_ppas' => $stats['rejected_ppas'],
            'monthly_rejected_ppas' => $stats['monthly_rejected_ppas'],
            'rejected_ppas_percentage' => number_format($rejected_ppas_percentage * 100, 2),
            'quotation_average_time' => $stats['ctz_pcts_average_time']
        ];
    }

    /*gets business days only without weekends*/
    private function getBusinessDays()
    {
        $start = (new Carbon('first day of this month'))->startOfDay();
        $end = (new Carbon('last day of this month'))->endOfDay();

        $business_days = $start->diffInDaysFiltered(function(Carbon $date) {
                    return !$date->isWeekend();
        }, $end);

        $business_days -= DB::table('business_days')->where('month', $start->month)->first()->amount;
        return $business_days;
    }
}
