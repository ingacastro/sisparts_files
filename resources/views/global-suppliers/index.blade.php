@extends('layouts.admin.master')
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Proveedores Globales</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Proveedores Globales
    <small></small>
</h1>
<div id="error_messages"></div>
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
                            <a href="{{ route('global-suppliers.create') }}" id="new_supplier" class="btn btn-circle green"> Nuevo
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
                            <th>Correo</th>
                            <th>País</th>
                            <th>Moneda</th>
                            <th>Teléfono</th>
                            <th>Brokers País</th>
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
@push('scripts')
<script src="{{ asset('metronic-assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('#suppliers_table').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ route('global-suppliers.get-list') }}",
        },
        columns: [
            { data: "name", name: "global_suppliers.name"},
            { data: "email", name: "global_suppliers.name"},
            { data: "country", name: "countries.name"},
            { data: "currency", name: "currencies.name"},
            { data: "telephone", name: "global_suppliers.name"},
            { data: "brokers_pais", name: "global_suppliers.brokers_pais"},
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
        }, 
    });

</script>
@endpush