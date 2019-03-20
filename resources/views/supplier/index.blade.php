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
        <span>Proveedores</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Proveedores
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
                                <a href="{{ route('supplier.create') }}" id="new_supplier" class="btn btn-circle green"> Nuevo
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="suppliers_table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Razón Social</th>
                            <th>País</th>
                            <th>RFC</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Contacto</th>
                            <th>Marcas</th>
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
<div class="modal fade bs-modal-lg" id="brands_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Marcas</h4>
            </div>
            {!! Form::open(['route' => 'supplier.sync-brands', 'method' => 'post', 'class' => 'horizontal-form', 'id' => 'brands_form']) !!}
                <input type="hidden" name="supplier_id" id="supplier_id">
                <input type="hidden" name="supplier_brands" id="supplier_brands" value="">
                <input type="hidden" name="redirect_to" value="supplier.index">
                <div class="modal-body">
                    @include('supplier.tabs.brands')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-circle default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-circle blue">Guardar</button>
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
<script src="/js/supplier/brands.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#sidebar_supplier').addClass('active');

        $('#suppliers_table').DataTable({
            serverSide: true,
            ajax: '/supplier/get-list',
            bSort: true,
            columns: [
                { data: "trade_name", name: "trade_name" },
                { data: "business_name", name: "business_name" },
                { data: "country", name: "country" },
                { data: "rfc", name: "rfc" },
                { data: "email", name: "email" },
                { data: "landline", name: "landline" },
                { data: "contact_name", name: "contact_name" },
                { 
                    data: 'brands',
                    render: function(data, type, row){
                        return data == null ? '' : data.split(',').join('</br>');
                    }
                },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }, 
        });
    });

    //needed to work with tab switching on create_update view
    $('#new_supplier').click(function(){
        localStorage.setItem('from_supplier_index', true);
    });
    $(document).click('.edit-supplier', function(e){
        localStorage.setItem('from_supplier_index', true);
    });

    /*Supplier delete*/
    function deleteModel(e, id) {
        e.preventDefault();
        swal({
          title: "Eliminar proveedor",
          text: "¿Seguro que deseas eliminar este proveedor?",
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
            url: '/supplier/' + id,
            method: 'delete',
            headers: {'X-CSRF-TOKEN': token},
            success: function() {
                document.location.reload();
            }
        });
    }

    $(document).on('click', '.show-brands', function(e) {

        let id = $(this).attr('data-id');
        $('#supplier_id').val(id);

        $('#brands_table').DataTable({
            destroy: true,
            ajax: '/supplier/get-brands/' + id,
            searching: false,
            info: false,
            lengthChange: false,
            sDom: '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            columns: [
                {'data': 'id'},
                {'data': 'name'},
                {'data': 'actions', name: 'actions', orderable: false, searchable: false}
            ]
        });
    });

</script>
@endpush
