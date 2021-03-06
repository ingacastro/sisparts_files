<?php $is_edit = isset($model->id); $action = $is_edit ? 'Editar' : 'Nuevo'; $cancel_btn = $is_edit ? 'Terminar' : 'Cancelar'; ?>
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
            <ul class="nav nav-tabs" id="supplier_tabs">
                <li>
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
                <div class="tab-pane " id="tab_0_content">
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
                                <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                @include('supplier.tabs.fiscal_data')
                            {!! Form::close() !!}
                            @else
                            <!-- Update -->
                            {!! Form::model($model, ['route' => ['supplier.update', $model->id], 'class' => 'horizontal-form', 'id' => 'fiscal_form', 'method' => 'put']) !!}
                                <input type="hidden" name="tabs_config" value="">
                                <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
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
                                <input type="hidden" name="redirect_to" value="supplier.edit">
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
        $('#sidebar_supplier').addClass('active');

        applyFieldsMasks();

        let model_id = $('#model_id').val();

        loadStates();

        setActiveTab();

        $('#brands_table').DataTable({
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

    $('#country').change(function(){
        loadStates();
    });

    /*Loads states based on country id*/
    function loadStates()
    {
        let country_id = $('#country_hidden').val();

        $.ajax({
            url: root_url + '/country-states',
            method: 'get',
            dataType: 'json',
            data: {'country_id': country_id},
            success: function(response) {

                //Enable/Disable state select/state_name input based in selected country
                let state_select = $('#states_id');
                let state_name = $('#state_name');
                state_select.prop('disabled', response.disabled);
                state_name.prop('disabled', !response.disabled);

                if(response.disabled) { 
                    $('#states_id').hide();
                    $('#state_name').show(); 
                }
                else { 
                    $('#states_id').show();
                    $('#state_name').hide(); 
                }

                $.each(response.states, function(id, name) {
                    state_select.append('<option value="' + id +'" >' + name + '</option>');
                });

            }
        });
    }

</script>
@endpush