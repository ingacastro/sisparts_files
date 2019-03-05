<?php $is_edit = isset($model->id); $action = $is_edit ? 'Editar' : 'Nuevo'; $cancel_btn = $is_edit ? 'Terminar' : 'Cancelar'; ?>
@extends('layouts.admin.master')
@section('meta-css')
<link href="/metronic-assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('home') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ route('supplier.index') }}">Proveedores</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{ $action }} Proveedor</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> {{ $action }} Proveedor
    <small></small>
</h1>
@include('layouts.admin.includes.error_messages')
@include('layouts.admin.includes.success_messages')
@endsection
@section('page-content')
<div class="row">
    <div class="col-md-12">
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_0_content" id="tab_0" data-toggle="tab"> Datos Básicos </a>
                </li>
                <li>
                    <a href="#tab_1_content" id="tab_1" data-toggle="tab"> Datos Fiscales </a>
                </li>
                @if($is_edit)
                <li>
                    <a href="#tab_2_content" id="tab_2" data-toggle="tab"> Marcas </a>
                </li>
                @endif
            </ul>
			<div class="tab-content">
                <div class="tab-pane active" id="tab_0_content">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>Datos Básicos</div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="" id="basic_form" class="horizontal-form">
                                @include('supplier.tabs.basic_data')
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                <div class="tab-pane " id="tab_1_content">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>Datos Fiscales</div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <!-- Create -->
                            @if(!$is_edit)
                            {!! Form::open(['route' => 'supplier.store', 'class' => 'horizontal-form', 'id' => 'fiscal_form']) !!}
                                <input type="hidden" name="tabs_config" value="">
                                @include('supplier.tabs.fiscal_data')
                            {!! Form::close() !!}
                            @else
                            <!-- Update -->
                            {!! Form::model($model, ['route' => ['supplier.update', $model->id], 'class' => 'horizontal-form', 'id' => 'fiscal_form', 'method' => 'put']) !!}
                                <input type="hidden" name="tabs_config" value="">
                                @include('supplier.tabs.fiscal_data')
                            {!! Form::close() !!}
                            @endif
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                @if($is_edit)
                <div class="tab-pane " id="tab_2_content">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>Marcas</div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {!! Form::open(['route' => 'supplier.sync-brands', 'method' => 'post', 'class' => 'horizontal-form', 
                            'id' => 'brands_form']) !!}
                                @include('supplier.tabs.brands')
                                <input type="hidden" name="supplier_id" value="{{ $model->id }}">
                                <input type="hidden" name="supplier_brands" id="supplier_brands" value="">
                            {!! Form::close() !!}
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="model_id" name="model_id" value="{{ $model->id }}">
@endsection
@push('scripts')
@include('utils.form_masks')
<script src="/metronic-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="/metronic-assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
@if($is_edit)
<script src="/metronic-assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/js/supplier/brands.js" type="text/javascript"></script>
@endif
<script type="text/javascript">
    $(document).ready(function(){
        $('#sidebar_supplier').addClass('active');
        let model_id = $('#model_id').val();

        //In edit mode enable state select
        if($.isNumeric(model_id)) $('#states_id').removeAttr("disabled");
    });

    //We copy every select selected option value into a hidden input
    $('.drop-down').change(function(){
        let select_val = $(this).val();
        $('#' + $(this).attr('id') + '_hidden').val(select_val);
        //console.log($('#' + $(this).attr('id') + '_hidden').val());
    });

    //We merge basic and fiscal forms every time one of them is submitted
    $('#fiscal_form').submit(function(e){
        $('#basic_form :input').not(':submit').clone().hide().prependTo('#fiscal_form');
    });

    $('#country').change(function(){
        loadStates();
    });

    /*Loads states based on country id*/
    function loadStates()
    {
        let country_id = $('#countries_id').val();
        $.ajax({
            url: '/country-states',
            method: 'get',
            dataType: 'json',
            data: {country_id: country_id},
            success: function(states) {
                let state_select = $('#states_id');
                state_select.removeAttr("disabled");
                $.each(states, function(id, name) {
                    state_select.append('<option value="' + id +'" >' + name + '</option>');
                });
            }
        });
    }

</script>
@endpush