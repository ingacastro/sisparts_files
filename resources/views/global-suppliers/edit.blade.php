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
                                            <input class="form-control" value="{{$globalSupplier->name}}" autocomplete="off" name="name" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="country"><span class="required">* </span>País</label>
                                                <select class="form-control drop-down" name="country_id">
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
                                                <input class="form-control" name="email" autocomplete="off" type="email"  value="{{$globalSupplier->email}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="language"><span class="required">* </span>Idioma</label>
                                                <select name="language_id" class="form-control drop-down" id="">
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
                                                value="{{$globalSupplier->telephone}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="currency">Moneda</label>
                                                <select name="currency_id" class="form-control drop-down" id="currency">
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
                                                <input name="phone" class="form-control" autocomplete="off" type="tel"  value="{{$globalSupplier->phone}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display:flex;     justify-content: space-around;">
                                            <div class="form-group" style="margin: 15px 0 0 0">
                                                <input type="checkbox" value="1"  name="marketplace"
                                                @if ($globalSupplier->marketplace)
                                                    {{'checked'}}
                                                @endif>
                                                <label style="margin: 20px 0 0 0">Marketplace</label>
                                                    <span aria-hidden="true" class="icon-question " style="font-size: 18px" title="Solo obligatorio capturar nombre, país, idioma."></span>
                                            </div>
                                            <div class="form-group" style="margin: 15px 0 0 0">
                                                <input type="checkbox" value="1" name="brokers_pais" 
                                                @if($globalSupplier->brokers_pais)
                                                  {{'checked'}}  
                                                @endif>
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
                                <i class=""></i>Marcas
                            </div>
                        </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form method="POST" accept-charset="UTF-8" class="horizontal-form" id="brands_form">
                            @csrf
                            <input type="hidden" name="globalSupplier" value="{{$globalSupplier->id}}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-5">
                                        <label for="brands_select2" class="control-label">Marca</label>
                                        <select class="form-control input-sm select2-multiple select2-hidden-accessible" id="brands_select2" style="width: 100%" tabindex="-1" aria-hidden="true" name="manufacturer">
                                            @foreach ($manufacturers as $manufacturer)
                                                <option value="{{ $manufacturer->id}}">{{ $manufacturer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button id="add_brand" type="button" class="btn btn-circle green" style="margin-top: 25px">
                                            <i class="fa fa-plus"></i> Agregar</button>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div id="brands_table_wrapper" class="dataTables_wrapper no-footer">
                                            <div class="row view-filter">
                                                <div class="col-sm-12">
                                                    <div class="pull-left"></div>
                                                    <div class="pull-right"></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <table class="table table-striped table-hover table-bordered dataTable no-footer" id="brands_table" style="width: 100%" role="grid">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting_asc" tabindex="0" aria-controls="brands_table" rowspan="1" colspan="1" style="width: 0px;" aria-sort="ascending" aria-label="Id: Activar para ordenar la columna de manera descendente">Id</th>
                                                        <th class="sorting" tabindex="0" aria-controls="brands_table" rowspan="1" colspan="1" style="width: 0px;" aria-label="Nombre: Activar para ordenar la columna de manera ascendente">Nombre</th>
                                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;" aria-label="Acciones">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @include('global-suppliers.brands')
                                                </tbody>
                                            </table>
                                            <div class="row view-pager">
                                                <div class="col-sm-12">
                                                    <div class="text-center">
                                                        <div class="dataTables_paginate paging_bootstrap_number" id="brands_table_paginate">
                                                            <ul class="pagination" style="visibility: hidden;">
                                                                <li class="prev disabled"><a href="#" title="Anterior"><i class="fa fa-angle-left"></i></a></li>
                                                                <li class="next disabled"><a href="#" title="Siguiente"><i class="fa fa-angle-right"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                            </div>
                            <div class="form-actions right">
                                <a href="http://localhost:8000/supplier" class="btn btn-circle default">Terminar</a>
                                <button type="submit" class="btn btn-circle blue">
                                    <i class="fa fa-check"></i> Guardar
                                </button>
                            </div>
                            <input type="hidden" name="supplier_id" value="3674">
                            <input type="hidden" name="supplier_brands" id="supplier_brands" value="">
                            <input type="hidden" name="redirect_to" value="supplier.edit">
                        </form>
                        <!-- END FORM-->
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
    // borrar marca relacionada
    const root_url = $('#root_url').attr('content')
    $(document).on('click','.delete-r', function(e){
        e.preventDefault()
        const elemet = $(this)
        
        $.ajax({
            url:  	    `${root_url}/global-suppliers-manufacturers/delete/${$(this).data('id')}/${$(this).data('manufacturer')}`,
            dataType: 	'JSON',
            type:		'get',
            success:    function (response) {
                $("#brands_table tbody").html(response.resultados)
            },
            error:function(x,xs,xt){
                console.log('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt)
            }
        })
        
    })

    // activar datos basicos
    function clickDatosBasicos() {
        const items = document.querySelector("#tab_0")
        items.click()
    }

    // Initialize Select2
    let select = $('#brands_select2').select2()
    let valueSelect = null

    $('#brands_select2').change(function(){
        valueSelect = $(this).val()
    })
    // agregar marca relacionada
    $("#add_brand").click(function(e){
        e.preventDefault()
        if (! valueSelect)
            return undefined

        $.ajax({
            url:  	    "{{ Route('global-suppliers-manufacturers') }}",
            data: 		$('#brands_form').serialize(),
            dataType: 	'json',
            type:		'post',
            success: function (response) {
                $('#brands_table tbody').html(response.resultados)
            },
            error:function(x,xs,xt){
                console.log('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt)
            }
        })
    })

    document.addEventListener("DOMContentLoaded", clickDatosBasicos)
</script>
@endpush                                