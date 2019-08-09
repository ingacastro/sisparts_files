@extends('layouts.admin.master')
@section('meta-css')
<link href="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
<meta id="document_id" content="{{ $document->id }}">
<meta id="meta_token" content="{{ @csrf_token() }}">
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
#edit_set_modal {
    padding-right: 0 !important;
}
.budget-currency-data {
    padding-top: 0 !important;
}
.checklist-container {
    padding-bottom: 10px;
}
.checklist-container > .checklist-buttons-container {
    text-align: center;
}
.checklist-question-mark {
    font-size: 18px;
}
.tab-content {
    border-top: none !important;
}
.sweet-alert {
  z-index: 100000;
  background-color: #f1f4f7;
}
.bootstrap-tagsinput { width: 100%; }

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
<h1 class="page-title"> Detalle PCT: {{ $document->number }}
    <small></small>
</h1>
{{-- @include('layouts.admin.includes.error_messages') --}}
@include('layouts.admin.includes.success_messages')
@endsection
@section('page-content')
<div class="row">
    <div class="col-md-12">
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
                                                    <a style="text-decoration: none; font-weight: bold; font-size: 20px;" data-target="#sets_turn_ctz_modal" data-toggle="modal" id="sets_turn_ctz">CTZ</a>
                                                </th>
                                                <th>
                                                    <a style="text-decoration: none;" href="#set_file_attachment_from_pct_modal" data-target="#set_file_attachment_from_pct_modal" data-toggle="modal" id="file_attachment">
                                                        <span aria-hidden="true" style="font-size: 18px; margin-left: 20px" class="icon-paper-clip">
                                                        </span>
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
                                    <span><span class="detail-title">Razón social: </span>{{ $document->sync_connection->display_name }}</span>
                                </td>
                                <td>
                                    <span><span class="detail-title">RFQ: </span>{{ $document->reference }}</span>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <span><span class="detail-title">Folio: </span>{{ $document->number }}</span>
                                </td>
                                <td>
                                    <span><span class="detail-title">Comprador: </span>{{ $document->buyer_name }}</span>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <span><span class="detail-title">Vendedor: </span>{{ $document->seller_number }}</span>
                                </td>
                                <td>
                                    <span><span class="detail-title">Moneda: </span>{{ $document->currency->name }}</span>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <span><span class="detail-title">Número CTZ: </span>{{ $document->siavcom_ctz_number }}</span>
                                </td>
                                <td>
                                    <span>
                                        <span class="detail-title">Fecha última actualización: </span>
                                        {{ $document->supply_sets->where('status', 9)->count() > 0 
                                        ? date('d/m/Y', strtotime($document->updated_at)) : null }}
                                    </span>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php $dealership = $document->dealership; ?>
                                    <span>
                                        <span class="detail-title">Cotizador: </span>
                                        {{ $dealership->number }} - {{ $dealership->user->name }}
                                    </span>
                                </td>
                                <td>
                                    @role('Administrador')
                                    <span><span class="detail-title">Cliente: </span>{{ $document->customer->trade_name }}</span>
                                    @endrole
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <span>
                                        <span class="detail-title">Ubicación del cliente: </span>
                                        {{ $document->customer->country }} - {{ $document->customer->post_code }}
                                    </span>
                                </td>
                                <td></td>
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
                            <th>Fabricante</th>
                            <th>Cant</th>
                            <th>U. Medida</th>
                            <th>Costo total</th>
                            <th>Precio total</th>
                            <th>Precio unitario</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <h3 class="form-section" style="color: red">Bitácora</h3>
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <a data-target="#custom_binnacle_entry_modal" data-toggle="modal" id="custom_binnacle_entry" class="btn btn-circle green"> Nueva entrada
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
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
    </div>
</div>
@include('inbox.modals.edit')
@include('inbox.modals.set_file_attachment_from_pct')
@include('inbox.modals.set_file_attachment')
@include('inbox.modals.quotation_request')
@include('inbox.modals.sets_turn_ctz')
@include('inbox.modals.custom_binnacle_entry')
@include('inbox.modals.set_rejection')
@endsection
@endsection
@push('scripts')
@include('utils.form_masks')
<script src="/metronic-assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="/metronic-assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="/js/inbox/index.js" type="text/javascript"></script>
<script src="/js/inbox/pct_edit.js" type="text/javascript"></script>
<script src="/js/inbox/file_attachment.js" type="text/javascript"></script>
<script src="/js/inbox/quotation_request.js" type="text/javascript"></script>
<script src="/js/inbox/sets_turn_ctz.js" type="text/javascript"></script>
<script src="/js/inbox/set_rejection.js" type="text/javascript"></script>
<script src="/js/inbox/binnacle_entry.js" type="text/javascript"></script>
<script type="text/javascript">
var root_url = $('#root_url').attr('content');
$(document).ready(function(){
    $('#sidebar_inbox').addClass('active');
    initSupplySetsTable();
    $('#binnacle_table').DataTable({
        serverSide: true,
        ajax: root_url + '/inbox/document-binnacle/{{ $document->id }}',
        bSort: true,
        destroy: true,
        columns: [
            { data: "created_at", name: "created_at" },
            { data: "entity", name: "entity" },
            { data: "type", name: "type" },
            { data: "user", name: "user" },
            { data: "comments", name: "comments" },
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
});

function initSupplySetsTable() {
    $('#supplies_table').DataTable({
        serverSide: true,
        ajax: {
            url: root_url + '/inbox/document-supplies',
            data: {
                'document_id': '{{ $document->id }}',
                'route': 'inbox'
            }
        },
        bSort: true,
        destroy: true,
        columns: [
            { data: "number", name: "number" },
            { data: "supplier", name: "supplier" },
            { data: "manufacturer", name: "manufacturer" },
            { data: "products_amount", name: "products_amount" },
            { data: "measurement_unit_code", name: "measurement_unit_code" },
            { data: "total_cost", name: "total_cost" },
            { data: "total_price", name: "total_price" },
            { data: "unit_price", name: "unit_price" },
            { data: "status", name: "status" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
}

$(document).on('click', '#close_set_edition_modal', function() {
    initSupplySetsTable();
});

$(document).on('click', '#calculate_volumetric_weight', function() {
    let unit = $('.budget-measurement-unit:checked').val();
    let length = $('#measurement_length').val();
    let width = $('#measurement_width').val();
    let height = $('#measurement_height').val();
/*    console.log(unit);
    console.log(length);
    console.log(width);
    console.log(height);*/
    $.get(root_url + '/inbox/get-volumetric-weight/2', { 'measurement[unit]': unit, 'measurement[length]': length, 'measurement[width]': width, 'measurement[height]': height}, function(response) {
        $('#pct_edit_modal_error_messages').empty();
        $('#pct_edit_modal_success_message').empty();
        
        if(response.errors)
            $('#pct_edit_modal_error_messages').html(response.errors_fragment);
        else  {
            $('#measurement_vol_weight').val(response.volumetric_weight);
        }
    });
});
</script>
@endpush
