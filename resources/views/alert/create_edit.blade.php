<?php $is_edit = isset($model->id); $action = $is_edit ? 'Editar' : 'Nueva'; ?>
@extends('layouts.admin.master')
@section('meta-css')
<link href="/metronic-assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
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
        <a href="{{ route('alert.index') }}">Alertas</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{ $action }} Alerta </span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> {{ $action }} Alerta
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
                <div class="caption"></div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                @if(!$is_edit)
                {!! Form::open(['route' => 'alert.store', 'class' => 'horizontal-form', 'id' => 'alert_form']) !!}
                @else
                {!! Form::model($model, ['route' => ['alert.update', $model->id], 'class' => 'horizontal-form', 'method' => 'put',
                'id' => 'alert_form']) !!}
                @endif
                @include('alert.base_form')
                {!! Form::close() !!}
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('utils.form_masks')
<script src="/metronic-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="/metronic-assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#sidebar_configuration').addClass('active');
    applyFieldsMasks();

    displayConditionTypeDynamicField();

});

$('#type').change(function() { displayConditionTypeDynamicField(); });

function displayConditionTypeDynamicField() {
    let val = $('#type').val();
    
    $('#condition_type_elapsed_days').hide();
    $('#condition_type_status_change').hide();
    
    if(val == 1)
        $('#condition_type_elapsed_days').show();
    else if(val == 2)
        $('#condition_type_status_change').show();
}

$('#alert_form').submit(function(e){
    e.preventDefault();
    let token = $('input[name=_token]').val();
    let serialized_form = $(this).serialize();
    let action = $(this).attr('action');
    
    $.ajax({
        url: action,
        type: 'post',
        dataType: 'json',
        data: serialized_form,
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            if(response.errors)
                $('#error_messages').html(response.errors_fragment);
            else
                location.href = '/alert';
        }
    });
});

</script>
@endpush