@extends('layouts.admin.master')
@section('meta-css')
<link href="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
{{-- <link href="/metronic-assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" /> --}}
<style>
.borderless td, .borderless th {
    border: none;
}
.borderless>thead>tr>th,
.borderless>tbody>tr>td {
  border:none;
  line-height: 12px;
}
.detail-title {
    font-weight: bold;
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
        <a href="{{ route('inbox.index') }}">Bandeja de entrada</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Detalle de PCT</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Detalle PCT: {{ $pct->number }}
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
                <div style="background: #f1f4f7;">  
                    <table class='table borderless'>
                        <thead>
                            <tr>
                                <th width="45%"></th>
                                <th width="45%"></th>
                                <th width="10%">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>
                                                    <a style="text-decoration: none; font-weight: bold; font-size: 20px;">CTZ</a>
                                                </th>
                                                <th>
                                                    <a style="text-decoration: none;">
                                                        <span aria-hidden="true" style="font-size: 18px; margin-left: 20px" class="icon-paper-clip"></span>
                                                    </a>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span><span class="detail-title">Razón social:</span> International Parts</span>
                                </td>
                                <td>
                                    <span><span class="detail-title">Número requerimiento:</span> 01234</span>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <span><span class="detail-title">Folio:</span> 001500</span>
                                </td>
                                <td>
                                    <span><span class="detail-title">Comprador:</span> 002</span>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <span><span class="detail-title">Cliente:</span> Altech S.A. de C.V.</span>
                                </td>
                                <td>
                                    <span><span class="detail-title">Cotizador:</span> 005 - Juan Pérez</span>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <span><span class="detail-title">Vendedor:</span> 003</span>
                                </td>
                                <td>
                                    <span><span class="detail-title">Moneda:</span> MXN</span>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
                <h3 class="form-section">Partes</h3>
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="supplies_table">
                    <thead>
                        <tr>
                            <th>Número parte</th>
                            <th>Proveedor</th>
                            <th>Cant</th>
                            <th>U. Medida</th>
                            <th>Costo total</th>
                            <th>Precio total</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <h3 class="form-section">Bitácora</h3>
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="binnacle_table">
                    <thead>
                        <tr>
                            <th>Fecha Hora</th>
                            <th>PCT/Num Parte</th>
                            <th>Tipo</th>
                            <th>Usuario</th>
                            <th>Comentarios</th>
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
{{-- <script src="/metronic-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="/metronic-assets/pages/scripts/components-select2.min.js" type="text/javascript"></script> --}}
<script src="/js/inbox/index.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#sidebar_inbox').addClass('active');

    $('#supplies_table').DataTable({
/*        serverSide: true,
        ajax: '/inbox/get-list',
        bSort: true,
        destroy: true,
        columns: [
            { data: "created_at", name: "created_at" },
            { data: "sync_connection", name: "sync_connection" },
            { data: "number", name: "number" },
            { data: "buyer", name: "buyer" },
            { data: "semaphore", name: "semaphore" },
            { data: "status", name: "status" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],*/
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
    $('#binnacle_table').DataTable({
/*        serverSide: true,
        ajax: '/inbox/get-list',
        bSort: true,
        destroy: true,
        columns: [
            { data: "created_at", name: "created_at" },
            { data: "sync_connection", name: "sync_connection" },
            { data: "number", name: "number" },
            { data: "buyer", name: "buyer" },
            { data: "semaphore", name: "semaphore" },
            { data: "status", name: "status" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],*/
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
});
</script>
@endpush
