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
        <span>Selectlist</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Selectlist Autorización
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
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <a href="{{ route('selectlistauth.create') }}" id="new_selectlistauth" class="btn btn-circle green"> Nuevo
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="selectlistauth_table">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Descripción</th>
                            <th>Estado</th>
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
@endsection
@endsection
@push('scripts')
<script src="/metronic-assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="/metronic-assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="/js/supplier/brands.js" type="text/javascript"></script>

<script type="text/javascript">
     var root_url = $('#root_url').attr('content');
    $(document).ready(function(){
        $('#sidebar_selectlistauth').addClass('active');

        $('#selectlistauth_table').DataTable({
            serverSide: true,
            ajax: root_url + '/selectlistauth/get-list',
            bSort: true,
            columns: [
                { data: "id", name: "id" },
                { data: "name", name: "name" },
                { data: "status", name: "status" },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }, 
        });
    });

    //needed to work with tab switching on create_update view
    $('#new_selectlistauth').click(function(){
        localStorage.setItem('from_selectlistauth_index', true);
    });
    $(document).click('.edit-selectlistauth', function(e){
        localStorage.setItem('from_selectlistauth_index', true);
    });

    /*selectlistauth delete*/
    function deleteModel(e, id) {
        e.preventDefault();
        swal({
          title: "Eliminar Item del select",
          text: "¿Seguro que deseas eliminar este Item?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Aceptar",
          closeOnConfirm: false
        },
        function(isConfirm) {
          if (isConfirm) { deleteRequest(id); }
        });
    }

    function deleteRequest(id) {
        let token = $('meta[name=_token]').attr('content');
        $.ajax({
            url: root_url + '/selectlistauth/' + id,
            method: 'delete',
            headers: {'X-CSRF-TOKEN': token},
            success: function() {
                document.location.reload();
            }
        });
    }

</script>
@endpush
