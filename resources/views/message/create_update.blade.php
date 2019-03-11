<?php $is_edit = isset($model->id); $action = $is_edit ? 'Editar' : 'Nuevo'; ?>
@extends('layouts.admin.master')
@section('meta-css')
<link href="/metronic-assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ route('message.index') }}">Mensajes</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>{{ $action }} Mensaje </span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> {{ $action }} Mensaje
    <small></small>
</h1>
@include('layouts.admin.includes.error_messages')
@include('layouts.admin.includes.success_messages')
@endsection
@section('page-content')
<div class="row">
    <div class="col-md-12">
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs">
                @for($i = 0; $i < 3; $i++)
                <li class="{{ $i == 0 ? 'active' : ''}}">
                    <a href="#tab_0_content" id="tab_0" data-toggle="tab"> Español </a>
                </li>
                @endfor
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_0_content">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>Español</div>
                        </div>
                        <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        @if(!$is_edit)
                        {!! Form::open(['route' => 'message.store', 'class' => 'horizontal-form']) !!}
                        @else
                        {!! Form::model($user, ['route' => ['message.update', $model->id], 'class' => 'horizontal-form', 'method' => 'put']) !!}
                        @endif
                        @include('message.base_form')
                        {!! Form::close() !!}
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
<script src="/metronic-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="/metronic-assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#sidebar_message').addClass('active');
      new Quill('#message_body', {
        modules: {
            toolbar: {
                container: [
                 ['bold', 'italic', 'underline', 'strike'],
                 [{ 'header': [1, 2, 3, 4, 5, false] }],
                 [{ 'align': [] }],
                 [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                 [{ 'color': [] }],
                ]
            }
        },
        theme: 'snow'
    });
});
</script>
@endpush