
@extends('layouts.admin.master')
@section('meta-css')
<link href="/metronic-assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .bootstrap-tagsinput { width: 100%; }
</style>
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Configuración </span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Configuración
    <small></small>
</h1>
<div id="error_messages"></div>
@include('layouts.admin.includes.success_messages')
@endsection
@section('page-content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">Días para cambiar semáforo</div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {!! Form::open(['route' => 'settings.store', 'class' => 'horizontal-form', 'id' => 'color_settings_form']) !!}
                @include('color_settings.form')
                {!! Form::close() !!}
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('utils.form_masks')
<script src="/metronic-assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#sidebar_settings').addClass('active');
    $('#color_settings_form').submit(function(e){
        e.preventDefault();
        let token = $('input[name=_token]').val();
        let serialized_form = $(this).serialize();
        console.log(serialized_form);
        $.ajax({
            url: '/color-settings',
            type: 'post',
            dataType: 'json',
            data: serialized_form,
            headers: {'X-CSRF-TOKEN': token},
            success: function(response) {
                if(response.errors)
                    $('#error_messages').html(response.errors_fragment);
                else
                    location.reload();
            }
        });
    });
});
</script>
@endpush