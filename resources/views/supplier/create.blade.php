@extends('layouts.admin.master')
@section('meta-css')}
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
                <li>
                    <a href="#tab_2" data-toggle="tab"> Marcas </a>
                </li>
            </ul>
			<div class="tab-content">
                <div class="tab-pane active" id="tab_0">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>Datos Básicos </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            @include('supplier.tabs.basic_data')
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush