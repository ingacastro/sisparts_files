@extends('layouts.admin.master')
@section('meta-css')
<meta name="_token" content="{{ csrf_token() }}">
<link href="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<style>
    .icon-buttons {
        font-size: 20px;
    }
</style>
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
                                <div class="input-group input-large date-picker input-daterange" id="report_date_ranges" data-date="" data-date-format="mm/dd/yyyy">
                                    <input type="text" class="form-control" name="from" id="start_date" autocomplete="off">
                                    <span class="input-group-addon"> Fechas </span>
                                    <input type="text" class="form-control" name="to" id="end_date" autocomplete="off"> 
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
                            <div class="pull-right">
                                <button type="submit" class="btn btn-circle blue">Generar</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right" id="print_buttons" style="display: none">
                                {!!Form::open(['route'=>'report.download-pcts-pdf', 'style' => 'display: inline' ])!!}
                                    <input type="hidden" id="pdf_data" name="data">
                                    <button type="submit" class="btn btn-circle red-mint" id="download_pdf" style="margin-right: 10px">
                                    <i class="fa fa-file-pdf-o icon-buttons"></i></button>
                                {!! Form::close() !!}
                                {!!Form::open(['route'=>'report.download-pcts-excel', 'style' => 'display: inline' ])!!}
                                    <input type="hidden" id="excel_data" name="data">
                                    <button type="submit" class="btn btn-circle green-meadow" id="download_excel">
                                    <i class="fa fa-file-excel-o icon-buttons"></i></button>
                                {!! Form::close() !!}
                            </div>
                        </div>
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
                            <th>No. CTZ</th>
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
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js" type="text/javascript"></script>
<script type="text/javascript">
     var root_url = $('#root_url').attr('content');
    $(document).ready(function(){
        $('#sidebar_report').addClass('active');
        $('#report_date_ranges').datepicker();
    });

    $('#filters_form').submit(function(e){
        e.preventDefault();

        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let sync_connection = $('#filters_sync_connection').val();
        let status = $('#filters_status').val();
        let dealer_ship = $('#filters_dealer_ship').val();
        let customer = $('#filters_customer').val();

        $('#report_table').show();

        let report_table = $('#report_table').DataTable({
            searching: false,
            destroy: true,
            //serverSide: true,
            ajax: {
                url: root_url + '/report/get-list',
                data: {'start_date': start_date, 'end_date': end_date, 'sync_connection': sync_connection, 
                'status': status, 'dealer_ship': dealer_ship, 'customer': customer}
            },
            bSort: true,
            columns: [
                { data: "sync_date", name: "sync_date" },
                { data: "send_date", name: "send_date" },
                { data: "elapsed_days", name: "elapsed_days" }, //Till quotation was turned into ctz
                { data: "company", name: "company" },
                { data: "number", name: "number" },
                { data: "reference", name: "reference" },
                { data: 'dealership', name: 'dealership' },
                { data: 'customer', name: 'customer' },
                { data: 'ctz_supplies', name: 'ctz_supplies' },
                { data: 'status', name: 'status' },
                { data: 'siavcom_ctz_number', name: 'siavcom_ctz_number' },
            ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }, 
        });
        $('#print_buttons').show();
    });

    $('#download_pdf').click(function(){
        var rows = JSON.stringify($('#report_table').DataTable().rows().data().toArray());
        $('#pdf_data').val(rows);
    });
    $('#download_excel').click(function(){
        var rows = JSON.stringify($('#report_table').DataTable().rows().data().toArray());
        $('#excel_data').val(rows);
    });

</script>
@endpush
