@extends('layouts.admin.master')
@section('meta-css')
<meta name="_token" content="{{ csrf_token() }}">
<link href="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                            <th>Razón social</th>
                            <th>Folio</th>
                            <th>Cotizador</th>
                            @if($logged_user_role == 'Administrador')<th>Cliente</th>@endif
                            <th>Semáforo</th>
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
            {!! Form::open(['route' => ['inbox.change-dealership', 34], 'method' => 'post', 'class' => 'horizontal-form',
                'id' => 'change_dealership_form']) !!}
                <div class="modal-body">
                    <div id="error_messages"></div>
                    <div class="form-group">
                        <label class="control-label" id="current_dealership"></label>
                    </div>
                    <div class="form-group">
                        <label for="dealerships_select2" class="control-label">Nuevo cotizador</label>
                        {!! Form::select('employees_users_id', $dealerships, null, ['class' => 'form-control', 'id' => 'dealerships_select2',
                        'style' =>'width: 100%', 'placeholder' => 'Seleccionar...']) !!}
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
<script src="/metronic-assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="/metronic-assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#sidebar_inbox').addClass('active');

    $('#inbox_table').DataTable({
        serverSide: true,
        ajax: '/inbox/get-list',
        bSort: true,
        columns: [
            { data: "created_at", name: "created_at" },
            { data: "sync_connection", name: "sync_connection" },
            { data: "number", name: "number" },
            { data: "buyer", name: "buyer" },
            @if($logged_user_role == 'Administrador'){ data: "customer", name: "customer" },@endif
            { data: "semaphore", name: "semaphore" },
            { data: "status", name: "status" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
});

$(document).on('click', '.change-dealership', function(){
    let current_dealership = $(this).attr('data-buyer');
    $('#current_dealership').html('Cotizador actual: ' + current_dealership);
    let document_id = $(this).attr('data-document_id');
    $('#document_id').val(document_id);
});

$('#change_dealership_form').submit(function(e){
    e.preventDefault();
    let serialized_form = $(this).serialize();
    let token = $('meta[name=_token]').attr('content');
    $.ajax({
        url: '/inbox/change-dealership',
        dataType: 'json',
        method: 'post',
        headers: {'X-CSRF-TOKEN': token},
        data: serialized_form,
        success: function(response) {
            if(response.errors)
                $('#error_messages').html(response.errors_fragment);
            else
                location.reload();
        }
    });
});


function archiveDocument(e, id) {
    e.preventDefault();
    swal({
      title: "Archivar",
      text: "¿Está seguro de archivar el elemento seleccionado?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",     
      cancelButtonText: "Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: false
    },
    function(isConfirm) {
      if (isConfirm) { archiveRequest(id); }
    });
}

function archiveRequest(id) {
    let token = $('meta[name=_token]').attr('content');
    $.ajax({
        url: '/inbox/' + id + '/archive',
        method: 'post',
        headers: {'X-CSRF-TOKEN': token},
        success: function() {
            document.location.reload();
        }
    });
}


</script>
@endpush
