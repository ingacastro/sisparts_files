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
                    <a href="#tab_0" data-toggle="tab"> Datos Básicos </a>
                </li>
                <li>
                    <a href="#tab_1" data-toggle="tab"> Datos Fiscales </a>
                </li>
                @if(isset($model->id))
                <li>
                    <a href="#tab_2" data-toggle="tab"> Marcas </a>
                </li>
                @endif
            </ul>
			<div class="tab-content">
                <div class="tab-pane active" id="tab_0">
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
                <div class="tab-pane " id="tab_1">
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
                <div class="tab-pane " id="tab_2">
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
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#sidebar_supplier').addClass('active');
    });

    //We merge basic and fiscal forms every time one of them is submitted
    $('#fiscal_form').submit(function(e){
        $('#basic_form :input').not(':submit').clone().hide().prependTo('#fiscal_form');
    });
    $('#basic_form').submit(function(e){
        $('#fiscal_form :input').not(':submit').clone().hide().appendTo('#basic_form');
    });
</script>
@endpush