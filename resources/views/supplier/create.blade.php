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
                            {!! Form::open(['route' => 'supplier.store', 'class' => 'horizontal-form']) !!}
                                @include('supplier.tabs.basic_data')
                            {!! Form::close() !!}
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_1">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>Datos Fiscales</div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {!! Form::open(['route' => 'supplier.store', 'class' => 'horizontal-form']) !!}
                                @include('supplier.tabs.fiscal_data')
                            {!! Form::close() !!}
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                @if(isset($model->id))
                <div class="tab-pane" id="tab_2">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>Marcas</div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {!! Form::open(['route' => 'supplier.store', 'class' => 'horizontal-form']) !!}
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
    $('#sidebar_supplier').addClass('active');
</script>
@endpush