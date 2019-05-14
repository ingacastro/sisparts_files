<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use IParts\User;
use IParts\Customer;
use IParts\Document;
use Yajra\Datatables\Datatables;
use IParts\Datatables\ReportDataTable;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use IParts\Exports\PCTSExport;
use PDF;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sync_connections = DB::table('sync_connections')->pluck('display_name', 'id')->prepend('TODAS', 0);
        $dealerships = User::role('Cotizador')->pluck('name', 'id')->prepend('TODOS', 0);
        $customers = Customer::pluck('trade_name', 'id')->prepend('TODOS', 0);
        return view('report.index', compact('sync_connections', 'dealerships', 'customers'));
    }

    public function getList(Request $request)
    {
        //Log::notice($request);

        $query = Document::select('documents.created_at as sync_date', 'documents.completed_date as send_date', 
            DB::raw('(CASE 
                WHEN documents.completed_date <> "" THEN DATEDIFF(documents.completed_date, documents.created_at)
                ELSE null END) as elapsed_days'),
            'sync_connections.name as company', 'documents.number','documents.reference', 
            'users.name as dealership', 'customers.trade_name as customer', 
            DB::raw('CONCAT(SUM(CASE WHEN documents_supplies.status = 9 THEN 1 ELSE 0 END), "/", COUNT(documents_supplies.id)) as ctz_supplies'),
            //DB::raw('COUNT(documents_supplies.id) as supplies'),
            DB::raw('(CASE WHEN documents.status = 1 THEN "Nueva"
                      WHEN documents.status = 2 THEN "En proceso"
                      WHEN documents.status = 3 THEN "Terminada"
                      WHEN documents.status = 4 THEN "Archivada"
                      ELSE "Indefinido" END) as status'))
            ->join('sync_connections', 'sync_connections.id', 'documents.sync_connections_id')
            ->join('employees', 'employees.users_id', 'documents.employees_users_id')
            ->join('users', 'users.id', 'employees.users_id')
            ->join('customers', 'customers.id', 'documents.customers_id')
            ->leftJoin('documents_supplies', 'documents_supplies.documents_id', 'documents.id')
            ->groupBy('documents.id', 'customers.trade_name');
            
            if(isset($request->start_date))
                $query->where('documents.created_at', '>=', date('Y-m-d H:i:s', strtotime($request->start_date . ' 00:00:00')));
            if(isset($request->end_date))
                $query->where('documents.created_at', '<=', date('Y-m-d H:i:s', strtotime($request->end_date . ' 23:59:59')));
            if(isset($request->sync_connection))
                $query->where('documents.sync_connections_id', $request->sync_connection);
            if(isset($request->status))
                $query->where('documents.status', $request->status);
            if(isset($request->dealer_ship))
                $query->where('documents.employees_users_id', $request->dealer_ship);
            if(isset($request->customer))
                $query->where('documents.customers_id', $request->customer);

        $datatable = DataTables::of($query->get())
              ->editColumn('sync_date', function($document){
                return date('d/m/Y', strtotime($document->sync_date));
              })
              ->editColumn('send_date', function($document){
                return isset($document->send_date) ? date('d/m/Y', strtotime($document->send_date)) : null;
              })->make(true);
              /*->editColumn('ctz_supplies', function($document){
                return $document->ctz_supplies . '/' . $document->supplies;
              })*/
              
        return $datatable;
    }

    public function downloadPCTSExcel(Request $request)
    {
        $pcts = $request->get('data');
        try {
            return Excel::download(new PCTSExport(json_decode($pcts)), 'reporte_pcts.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function downloadPCTSPDF(Request $request)
    {

        $pcts = json_decode($request->get('data'));
        try {
            $pdf = PDF::loadView('report.exports.pdf', compact('pcts'))->setPaper('a4', 'landscape');
            return $pdf->download('reporte_pcts.pdf');
        }catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
