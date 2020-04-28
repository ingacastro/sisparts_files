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
        <span>Proveedor Brokers</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title">Proveedor Brokers</h1>
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
                    <a href="#tab_1_content" id="tab_1" data-toggle="tab"> Marcas </a>
                </li>
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
                            <form action="{{route('global-suppliers.update', $globalSupplier->id)}}" method="post" id="basic_form" class="horizontal-form">
                                @csrf
                                @method('put')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="trade_name"><span class="required">* </span>Nombre comercial</label>
                                            <input class="form-control" value="{{$globalSupplier->name}}" autocomplete="off" name="name" type="text" readonly="" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="country"><span class="required">* </span>País</label>
                                                <select class="form-control drop-down" name="country_id" readonly="" disabled="">
                                                    @foreach ($countries as $country)
                                                        <option value="{{$country->id}}" 
                                                            @if($country->id == $globalSupplier->country_id)
                                                                {{'selected'}}
                                                            @endif
                                                        >{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="email"><span class="required">* </span>Correo electrónico</label>
                                                <input class="form-control" name="email" autocomplete="off" type="email"  value="{{$globalSupplier->email}}" readonly="" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="language"><span class="required">* </span>Idioma</label>
                                                <select name="language_id" class="form-control drop-down" id="" readonly="" disabled="">
                                                    @foreach ($languages as $language)
                                                        <option value="{{$language->id}}"
                                                            @if($language->id == $globalSupplier->language_id)
                                                                {{'selected'}}
                                                            @endif
                                                            >{{$language->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="landline"><span class="required">* </span>Teléfono fijo</label>
                                                <input name="telephone" class="form-control" id="" autocomplete="off" type="tel" 
                                                value="{{$globalSupplier->telephone}}" readonly="" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="currency">Moneda</label>
                                                <select name="currency_id" class="form-control drop-down" id="currency" readonly="" disabled="">
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{$currency->id}}"
                                                            @if($currency->id == $globalSupplier->currency_id)
                                                                {{'selected'}}
                                                            @endif
                                                            >{{$currency->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="landline">Teléfono móvil</label>
                                                <input name="phone" class="form-control" autocomplete="off" type="tel"  value="{{$globalSupplier->phone}}" readonly="" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display:flex;     justify-content: space-around;">
                                            <div class="form-group" style="margin: 15px 0 0 0">
                                                <input type="checkbox" value="1"  name="marketplace"
                                                @if ($globalSupplier->marketplace)
                                                    {{'checked'}}
                                                @endif readonly="" disabled="">
                                                <label style="margin: 20px 0 0 0">Marketplace</label>
                                                    <span aria-hidden="true" class="icon-question " style="font-size: 18px" title="Solo obligatorio capturar nombre, país, idioma."></span>
                                            </div>
                                            <div class="form-group" style="margin: 15px 0 0 0">
                                                <input type="checkbox" value="1" name="brokers_pais" 
                                                @if($globalSupplier->brokers_pais)
                                                  {{'checked'}}  
                                                @endif disabled readonly>
                                                <label style="margin: 20px 0 0 0">Proveedor País</label>
                                                    <span aria-hidden="true" class="icon-question " style="font-size: 18px" title="Este proveedor será útil cuando se necesite un proveedor especifico en un país especifico, por alguna razón, sea que el proveedor no exporta o no se pueda por alguna razón comprar directo con el proveedor"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions right">
                                    <a href="/" class="btn btn-circle default">Cancelar</a>
                                    <button type="submit" class="btn btn-circle blue">
                                        <i class="fa fa-check"></i> Guardar</button>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                <div class="tab-pane " id="tab_1_content">
                  <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=""></i>Marcas</div>
                    </div>
                    <div class="portlet-body form">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('metronic-assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
@if(false)
<script src="{{ asset('metronic-assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/supplier/brands.js') }}" type="text/javascript"></script>
@endif
<script>
    document.addEventListener("DOMContentLoaded", prueba)

    function prueba() {
        const items = document.querySelector("#tab_0")
        items.click()
    }
</script>
@endpush