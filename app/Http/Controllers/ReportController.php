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
        $documents = Document::select('documents.created_at as sync_date', 'documents.completed_date as send_date', 
            DB::raw('(CASE 
                WHEN documents.completed_date <> "" THEN DATEDIFF(documents.completed_date, documents.created_at)
                ELSE null END) as elapsed_days'),
            'sync_connections.name as company', 'documents.number','documents.reference', 
            'users.name as dealership', 'customers.trade_name as customer', 
            DB::raw('SUM(CASE WHEN documents_supplies.status = 9 THEN 1 ELSE 0 END) as ctz_supplies'),
            DB::raw('COUNT(documents_supplies.id) as supplies'),
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
            ->groupBy('documents.id', 'customers.trade_name')
            //->where('documents.id', 1008000)
            ->get();

        Log::notice($documents);

        $datatable = DataTables::of($documents)
              ->editColumn('sync_date', function($document){
                return date('d/m/Y', strtotime($document->sync_date));
              })
              ->editColumn('send_date', function($document){
                return isset($document->send_date) ? date('d/m/Y', strtotime($document->send_date)) : null;
              })
              ->editColumn('ctz_supplies', function($document){
                return $document->ctz_supplies . '/' . $document->supplies;
              })->make(true);
              
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
        //Log::notice($request);
        //return (new InvoicesExport)->download('invoices.pdf', \Maatwebsite\Excel\Excel::TCPDF);
        $pcts = $request->get('data');
        try {
            return Excel::export(new PCTSExport(json_decode($pcts)), 'reporte_pcts.pdf', \Maatwebsite\Excel\Excel::TCPDF);
        }catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
