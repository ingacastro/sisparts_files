@extends('layouts.admin.master')
@section('meta-css')
<meta name="_token" content="{{ csrf_token() }}">
<link href="{{ asset('metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('metronic-assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('metronic-assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Bandeja de entrada</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Bandeja de entrada
    <small></small>
</h1>
{{-- @include('layouts.admin.includes.error_messages') --}}
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
                {!! Form::open(['route' => 'inbox.get-list', 'id' => 'filters_form']) !!}
                    <label class="control-label" for="language">Filtros</label>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::select('sync_connection', $sync_connections, null, 
                                ['placeholder' => 'Empresa...', 'class' => 'form-control drop-down', 'id' => 'filters_sync_connection']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::select('status', [0 => 'TODOS', 1 => 'Nueva', 2 => 'En proceso'], null, 
                                ['placeholder' => 'Estatus...', 'class' => 'form-control drop-down', 'id' => 'filters_status']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::select('dealer_ship',  $dealerships, null, 
                                ['placeholder' => 'Asignado...', 'class' => 'form-control drop-down', 'id' => 'filters_dealer_ship']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-circle blue">Filtrar</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="inbox_table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Empresa</th>
                            <th>PCT</th>
                            <th>RFQ</th>
                            <th>Asignado</th>
                            <th>Edad</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<!--Reasign dealership's modal-->
<div class="modal fade bs-modal" id="brands_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Reasignar cotizador</h4>
            </div>
            {!! Form::open(['route' => 'inbox.change-dealership', 'method' => 'post', 'class' => 'horizontal-form',
                'id' => 'change_dealership_form']) !!}
                <div class="modal-body">
                    <div id="error_messages"></div>
                    <div class="form-group">
                        <label class="control-label" id="current_dealership"></label>
                    </div>
                    <div class="form-group">
                        <?php $modal_dealerships = $dealerships; unset($modal_dealerships[0])?>
                        <label for="dealerships_select2" class="control-label">Nuevo cotizador</label>
                        {!! Form::select('employees_users_id', $modal_dealerships, null, ['class' => 'form-control', 
                            'id' => 'dealerships_select2', 'style' =>'width: 100%', 'placeholder' => 'Seleccionar...']) !!}
                    </div>
                    <input type="hidden" name="document_id" id="document_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-circle default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-circle blue">Cambiar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@endsection
@push('scripts')
<script src="{{ asset('metronic-assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/inbox/index.js') }}" type="text/javascript"></script>
<script type="text/javascript">
var root_url = $('#root_url').attr('content');
$(document).ready(function(){
    $('#sidebar_inbox').addClass('active');

    buildDataTable({'route': 'inbox'});
    
});

$('#filters_form').submit(function(e){
    e.preventDefault();
    let sync_connection = $('#filters_sync_connection').val();
    let status = $('#filters_status').val();
    let dealer_ship = $('#filters_dealer_ship').val();

    let ajaxData = {
        'sync_connection': sync_connection, 
        'status': status, 
        'dealer_ship': dealer_ship, 
        'route': 'inbox'
    };

    buildDataTable(ajaxData);

});

function buildDataTable(ajaxData) {
    $('#inbox_table').DataTable({
        serverSide: true,
        ajax: {
            url: root_url + '/inbox/get-list',
            data: ajaxData
        },
        bSort: true,
        order: [],
        destroy: true,
        columns: [
            { data: "created_at", name: "created_at", searchable: false },
            { data: "sync_connection", name: "sync_connections.display_name" },
            { data: "number", name: "documents.number" },
            { data: "reference", name: "documents.reference" },
            { data: "buyer", name: "users.name" },
            { data: "semaphore", name: "semaphore", searchable: false, orderable: false },
            { data: "status", name: "status", searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
        }, 
    });
}
</script>
@endpush
