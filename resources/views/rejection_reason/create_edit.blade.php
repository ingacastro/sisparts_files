<?php $is_edit = isset($model->id); $action = $is_edit ? 'Editar' : 'Nuevo'; ?>
@extends('layouts.admin.master')
@section('meta-css')
<link href="{{ asset('metronic-assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ route('rejection-reason.index') }}">Motivos de rechazo</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{ $action }} Motivo De Rechazo </span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> {{ $action }} Motivo De Rechazo
    <small></small>
</h1>
@include('layouts.admin.includes.error_messages')
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
                @if(!$is_edit)
                {!! Form::open(['route' => 'rejection-reason.store', 'class' => 'horizontal-form']) !!}
                @else
                {!! Form::model($model, ['route' => ['rejection-reason.update', $model->id], 'class' => 'horizontal-form', 'method' => 'put']) !!}
                @endif
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="title"><span class="required">*</span>Título</label>
                                {!! Form::text('title', $model->title, ['class' => 'form-control', 'id' => 'title',
                                'autocomplete' => 'off'])!!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions right">
                    <a href="{{ route('rejection-reason.index') }}" class="btn btn-circle default">Cancelar</a>
                    <button type="submit" class="btn btn-circle blue">
                        <i class="fa fa-check"></i> Guardar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('utils.form_masks')
<script src="{{ asset('metronic-assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#sidebar_rejection_reason').addClass('active');
    applyFieldsMasks();
});
</script>
@endpush