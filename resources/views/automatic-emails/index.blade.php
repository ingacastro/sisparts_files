@extends('layouts.admin.master')
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Envio automatico</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Envio automatico para el envio de correo en las PCT
    <small></small>
</h1>
<div id="error_messages"></div>
@include('layouts.admin.includes.success_messages')
@endsection
@section('page-content')
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class=""></i>Cantidad de correos por PCT <small class="act ml-2" style="margin-left: 20px;"></small></div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="" id="quantity_email_form" class="horizontal-form">
				@method('put')
				@csrf
                <div class="form-body">
                    <div class="row" style="display: flex; align-items: flex-end;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="trade_name"><span class="required">* </span>Número de correos a enviar</label>
                            <input class="form-control" id="quantity" autocomplete="off" name="quantity" type="number" value="{{$quantity->quantity}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary">Guardar</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row" style="align-items: center; display: flex;">
								<div class="col-md-3" style="color:#3598dc; font-size: 3em;"><span id="cantidad">{{$quantity->quantity}}</span></div>
								<div class="col-md-9"><span class="palabraC">correos</span> a proveedores <br> por nro de parte</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
</div>
@endsection
@push('scripts')
	<script type="text/javascript">
	
		$(document).ready(function () {
			let form        = document.getElementById('quantity_email_form')
			let quantity    = document.getElementById('quantity').value
			
			$(form).submit(function (e) {
				e.preventDefault()
				$.ajax({
					url:  		"{{ Route('automatic-emails.update', 1) }}",
					data: 		$(form).serialize(),
					dataType: 	'json',
					type:		'post',
					success: function (response) {
						$('.act').text(response.mensaje)
						$("#cantidad").text(response.quantity)
					},
					error:function(x,xs,xt){
						console.log('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt)
					}
            	});
			})
		})
		
    </script>
@endpush