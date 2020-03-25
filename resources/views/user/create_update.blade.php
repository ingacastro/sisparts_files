<?php $is_edit = isset($user->id); $action = $is_edit ? 'Editar' : 'Nuevo'; ?>
@extends('layouts.admin.master')
@section('meta-css')
<link href="{{ asset('metronic-assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
{{-- <link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" /> --}}
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ route('user.index') }}">Usuarios</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{ $action }} Usuario </span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> {{ $action }} Usuario
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
                <!-- BEGIN FORM-->
                @if(!$is_edit)
                {!! Form::open(['route' => 'user.store', 'class' => 'horizontal-form']) !!}
                @else
                {!! Form::model($user, ['route' => ['user.update', $user->id], 'class' => 'horizontal-form', 'method' => 'put']) !!}
                @endif
                @include('user.base_form')
                {!! Form::close() !!}
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('utils.form_masks')
<script src="{{ asset('metronic-assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic-assets/pages/scripts/components-select2.min.js"') }} type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#sidebar_user').addClass('active');
    applyFieldsMasks();
});
</script>
@endpush