<?php 
$is_edit = isset($model->id); 
$action = $is_edit ? 'Editar' : 'Nuevo'; 
$cancel_btn = $is_edit ? 'Terminar' : 'Cancelar'; 
?>
@extends('layouts.admin.master')
@section('meta-css')
<link href="{{ asset('metronic-assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('metronic-assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
<meta id="auth_user_is_admin" content="{{Auth::user()->hasRole('Administrador')}}">
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ route('supplier.index') }}">Checklist</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{ $action }} Checklist</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> {{ $action }} Checklist
    <small></small>
</h1>
@include('layouts.admin.includes.error_messages')
@include('layouts.admin.includes.success_messages')
@endsection
@section('page-content')
<div class="row">
    <div class="col-md-12">
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs" id="supplier_tabs">
                <li>
                    <a href="#tab_0_content" id="tab_0" data-toggle="tab"> Datos Básicos </a>
                </li>
            </ul>
			<div class="tab-content">
                <div class="tab-pane " id="tab_0_content">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>Datos Básicos
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="" id="basic_form" class="horizontal-form">
                                @include('checklistauth.tabs.form')
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="model_id" name="model_id" value="{{ $model->id }}">
@endsection
@push('scripts')
@include('utils.form_masks')
<script src="{{ asset('metronic-assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
@if($is_edit)
<script src="{{ asset('metronic-assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/supplier/brands.js') }}" type="text/javascript"></script>
@endif
<script type="text/javascript">
     var root_url = $('#root_url').attr('content');
    $(document).ready(function(){
        $('#sidebar_checklistauth').addClass('active');

        applyFieldsMasks();

        let model_id = $('#model_id').val();

        setActiveTab();

        
    });

    //Set active tab from local storage
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('supplier_active_tab', $(e.target).attr('href'));
        localStorage.setItem('from_supplier_index', false);
    });
    function setActiveTab() {
        
        let activeTab = localStorage.getItem('supplier_active_tab');
        let fromSuppIndex = localStorage.getItem('from_supplier_index');

        if(fromSuppIndex == 'false' && activeTab){
            $('#supplier_tabs a[href="' + activeTab + '"]').tab('show');
        } else {
            $('#supplier_tabs a[href="#tab_0_content"]').tab('show');
        }
    }

    //We copy every select selected option value into a hidden input
    $('.drop-down').change(function(){
        let select_val = $(this).val();
        $('#' + $(this).attr('id') + '_hidden').val(select_val);
    });

    //We merge basic and fiscal forms every time one of them is submitted
    $('#fiscal_form').submit(function(e){
        $('#basic_form :input').not(':submit').clone().hide().prependTo('#fiscal_form');
    });

</script>
@endpush