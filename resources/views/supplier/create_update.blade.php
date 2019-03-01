@extends('layouts.admin.master')
@section('meta-css')
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('home') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Proveedores</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Nuevo Proveedor
    <small></small>
</h1>
@include('layouts.admin.includes.error_messages')
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
                @if(isset($model->id))
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
                            {{-- {!! Form::open(['route' => 'supplier.store', 'class' => 'horizontal-form', 'id' => 'basic_form']) !!} --}}
                            <form action="" id="basic_form" class="horizontal-form">
                                @include('supplier.tabs.basic_data')
                            </form>
                            {{-- {!! Form::close() !!} --}}
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
                            {!! Form::open(['route' => ['supplier.store', $model], 'class' => 'horizontal-form', 'id' => 'fiscal_form']) !!}
                                @include('supplier.tabs.fiscal_data')
                            {!! Form::close() !!}
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                @if(isset($model->id))
                <div class="tab-pane " id="tab_2_content">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>Marcas</div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {!! Form::open(['route' => 'supplier.store', 'method' => 'post', 'class' => 'horizontal-form', 
                            'id' => 'brands_form']) !!}
                                @include('supplier.tabs.brands')
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
<input type="hidden" id="model_id" value="{{ $model->id }}">
@endsection
@push('scripts')
@include('utils.form_masks')
<script type="text/javascript">
    $(document).ready(function(){
        $('#sidebar_supplier').addClass('active');
        let model_id = $('#model_id').val();
        //In edit mode enable state select
        if($.isNumeric(model_id)) $('#states_id').removeAttr("disabled");
    });

    //Laravel collective by default is not changing selected option
    $('.drop-down').change(function(){
        let select_val = $(this).val();
        console.log(select_val);
        $('#' + $(this).attr('id') + '_hidden').val(select_val);
    });

    //We merge basic and fiscal forms every time one of them is submitted
    $('#fiscal_form').submit(function(e){
        let basic_form = $('#basic_form :input');
        let basic_form_clone = basic_form.clone();
        basic_form_clone.hide().prependTo('#fiscal_form');

        //Especial case for selects
        //get original selects into a jq object
/*        var originalSelects = basic_form.find('select');
        basic_form_clone.find('select').each(function(index, item) {
             //set new select to value of old select
             $(item).val(originalSelects.eq(index).val());
             console.log(item);
        });*/
    });

    $('#basic_form').submit(function(e){
        $('#fiscal_form :input').not(':submit').clone().hide().appendTo('#basic_form');
    });

    $('#countries_id').change(function(){
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