@extends('layouts.admin.master')
@section('meta-css')
<meta name="_token" content="{{ csrf_token() }}">
<meta id="root_url" content="{{ url('/') }}">
<link href="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
<style>
    .sweet-alert {
        z-index: 99999 !important;
        background-color: #eef1f5;
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
        <span>Productos</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Productos
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
{{--                 <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <a href="{{ route('user.create') }}" class="btn btn-circle green"> Nuevo
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <table class="table table-striped table-hover table-bordered" id="supplies_table">
                    <thead>
                        <tr>
                            <th>No. parte</th>
                            <th>Marca</th>
                            <th>Descripción corta</th>
                            <th>Descripción larga</th>
                            <th>Proveedores</th>
                            <th>Adjuntos</th>
                            <th>Acciones</th>
{{--                            <th>Reemplazos</th>
                            <th>Observaciones</th>
                            <th>Cortizaciones</th> --}}
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@include('supply.modals.replacement_observation')
@include('supply.modals.pcts')
@endsection
@endsection
@push('scripts')
<script src="/metronic-assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/js/supply/index.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sidebar_supply').addClass('active');

        let root_url = $('#root_url').attr('content');

        let table = $('#supplies_table').DataTable({
            serverSide: true,
            ajax: '/supply/get-list',
            bSort: true,
            columns: [
                { data: "number", name: "number" },
                { data: "manufacturer", name: "manufacturer" },
                { data: "short_description", name: "short_description" },
                { data: "large_description", name: "large_description" },
                {
                    data: 'suppliers',
                    render: function(data, type, row){
                        return data == null ? '' : data.split(',').join('</br>');
                    }
                },
                { 
                    data: 'files',
                    render: function(data, type, row){
                        if(data == null)
                            return '';
                        else {
                            let files = data.split(',');
                            $.each(files, function(k, v){
                                let url = root_url + '/' + v;
                                files[k] = '<a href="' + url + '" download>Archivo ' + (k+1) + '</a>';
                            });
                            return files.join('</br>');
                        }
                    }
                },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });

        //var abcFromUrl = Request.QueryString["number"] ?? string.Empty;
        let url = window.location.href;
        url = new URL(url);
        let supply_number = url.searchParams.get("number");
        if(supply_number != null)
            table.search(supply_number).draw();
    });

    /*Supplier delete*/
/*    function deleteModel(e, id) {
        e.preventDefault();
        swal({
          title: "Eliminar usuario",
          text: "¿Seguro que deseas eliminar este usuario?",
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
            url: '/user/' + id,
            method: 'delete',
            headers: {'X-CSRF-TOKEN': token},
            success: function() {
                document.location.reload();
            }
        });
    }*/
</script>
@endpush
