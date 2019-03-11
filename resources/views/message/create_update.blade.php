<?php $is_create = isset($model->id); $action = $is_create ? 'Nuevo' : 'Editar'; ?>
@extends('layouts.admin.master')
@section('meta-css')
<link href="/metronic-assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/plugins/quill-1.3.6/css/quill.snow.css" rel="stylesheet">
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
            <ul class="nav nav-tabs" id="language_tabs">
                @foreach($selects_options['messages'] as $k => $message)
                <li id="tab_{{ $k }}" class="{{ $k == 0 ? 'active' : null }}">
                    <a href="#tab_{{ $k }}_content" data-toggle="tab" id="tab_anchor_{{ $k }}" class="tab-anchor"> 
                        {{ $message->language->name }} </a>
                </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($selects_options['messages'] as $k => $message)
                <div class="tab-pane {{ $k == 0 ? 'active' : null }}" id="tab_{{ $k }}_content">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>{{ $message->language->name }}</div>
                        </div>
                        <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        {{-- @if(!$is_edit) --}}
                        {!! Form::open(['route' => 'message.store', 'class' => 'horizontal-form message-form']) !!}
{{--                         @else
                        {!! Form::model($model, ['route' => ['message.update', $model->id], 'class' => 'horizontal-form message-form', 
                        'method' => 'put']) !!}
                        @endif --}}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="{{ $message->id }}">
                                        <label for="languages_id" class="control-label"><span class="required">* </span>Idioma</label>
                                        {!! Form::select('languages_id', $selects_options['languages'], $message->languages_id, ['class' => 'form-control', 'id' => 'languages_id', 'placeholder' => 'Seleccionar...']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name"><span class="required">* </span>Título</label>
                                        {!! Form::text('title', $message->title, ['class' => 'form-control', 'id' => 'name',
                                        'autocomplete' => 'off'])!!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name"><span class="required">* </span>Asunto</label>
                                        {!! Form::text('subject', $message->subject, ['class' => 'form-control', 'id' => 'subject',
                                        'autocomplete' => 'off'])!!}
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="message_body_{{ $k }}" style="height: 350px"></div>
                                    <input type="hidden" name="body" id="message_body_hidden">
                                </div>
                            </div>
                        </div>
                        <div class="form-actions right">
                            <a href="{{ route('message.index') }}" class="btn btn-circle default">Cancelar</a>
                            <button type="submit" class="btn btn-circle blue">
                                <i class="fa fa-check"></i> Guardar</button>
                        </div>
                        {!! Form::close() !!}
                        <!-- END FORM-->
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="/metronic-assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="/metronic-assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="/plugins/quill-1.3.6/js/quill.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#sidebar_message').addClass('active');
    let active_tab_id = $("#language_tabs li.active").attr('id').split('_')[1];
    initializeWYSIWYG(active_tab_id);
});

$('.tab-anchor').click(function(){
    let active_tab_id = $(this).attr('id').split('_')[2];
    initializeWYSIWYG(active_tab_id);
});

function initializeWYSIWYG(id) {
        $('.ql-toolbar').remove();
        new Quill('#message_body_' + id, {
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
}

$('.message-form').submit(function(e){
    let active_tab_id = $("#language_tabs li.active").attr('id').split('_')[1];
    let wysiwyg = document.querySelector('#message_body_' + active_tab_id);
    let wysiwyg_content = wysiwyg.children[0].innerHTML;
    $('#message_body_hidden').val(wysiwyg_content);
});
</script>
@endpush