@extends('layouts.admin.master')
@section('meta-css')
<meta name="_token" content="{{ csrf_token() }}">
<link href="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Reporte de cotizaciones generadas</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Reporte de cotizaciones generadas
    <small></small>
</h1>
@include('layouts.admin.includes.error_messages')
@include('layouts.admin.includes.success_messages')
@endsection
@section('page-content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                </div>
            </div>
            <div class="portlet-body">
                {!! Form::open(['route' => 'report.get-list', 'id' => 'filters_form']) !!}
                    <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                                <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                    <input type="text" class="form-control" name="from">
                                    <span class="input-group-addon"> Fechas </span>
                                    <input type="text" class="form-control" name="to"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::select('sync_connection', $sync_connections, null, 
                                ['placeholder' => 'Empresa...', 'class' => 'form-control drop-down', 'id' => 'filters_sync_connection']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::select('status', [0 => 'TODOS', 1 => 'Nueva', 2 => 'En proceso', 3 => 'Terminada'], null, 
                                ['placeholder' => 'Estatus...', 'class' => 'form-control drop-down', 'id' => 'filters_status']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::select('dealer_ship',  $dealerships, null, 
                                ['placeholder' => 'Cotizador...', 'class' => 'form-control drop-down', 'id' => 'filters_dealer_ship']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::select('customer',  $customers, null, 
                                ['placeholder' => 'Cliente...', 'class' => 'form-control drop-down', 'id' => 'filters_customer']) !!}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="submit" class="btn btn-circle blue">Generar</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="report_table" style="display: none">
                    <thead>
                        <tr>
                            <th>Fecha recibida</th>
                            <th>Fecha enviada</th>
                            <th>Tiempo de respuesta (días)</th>
                            <th>Empresa</th>
                            <th>Folio</th>
                            <th>Referencia</th>
                            <th>Cotizador</th>
                            <th>Cliente</th>
                            <th>Items cotizados</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endsection
@endsection
@push('scripts')
<script src="/metronic-assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sidebar_report').addClass('active');

        $('.input-daterange').datepicker();
    });

$('#filters_form').submit(function(e){
    e.preventDefault();
    $('#report_table').show();
    $('#report_table').DataTable({
        searching: false,
/*        serverSide: true,
        ajax: '/report/get-list',
        bSort: true,
        columns: [
            { data: "sync_date", name: "sync_date" },
            { data: "send_date", name: "send_date" },
            { data: "elapsed_days", name: "elapsed_days" }, //Till quotation was turned into ctz
            { data: "company", name: "company" },
            { data: "folio", name: "folio" },
            { data: "reference", name: "reference" },
            { data: 'dealership', name: 'dealership' },
            { data: 'customer', name: 'customer' },
            { data: 'supplies', name: 'supplies' },
            { data: 'status', name: 'status' },
        ],*/
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
});
</script>
@endpush
