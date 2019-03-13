<?php $is_create = !isset($message->id); $action = $is_create ? 'Nuevo' : 'Editar'; ?>
@extends('layouts.admin.master')
@section('meta-css')
<meta name="is_create" content="{{ $is_create }}">
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
<div id="error_messages"></div>
@include('layouts.admin.includes.success_messages')
@endsection
@section('page-content')
<div class="row">
    <div class="col-md-12">
        <div class="tabbable-line boxless tabbable-reversed">
            <ul class="nav nav-tabs" id="language_tabs">
                @foreach($languages as $k => $language)
                <li id="tab_{{ $k }}">
                    <a href="#tab_{{ $k }}_content" data-toggle="tab" id="tab_anchor_{{ $k }}" class="tab-anchor"> 
                        {{ $language->name }} </a>
                </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($languages as $k => $language)
                <div class="tab-pane " id="tab_{{ $k }}_content">
                  <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>{{ $language->name }}</div>
                        </div>
                        <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        @if($is_create)
                        {!! Form::open(['route' => 'message.store', 'class' => 'horizontal-form message-form']) !!}
                        @else
                        {!! Form::model($language, ['route' => ['message.update', $language->id], 'class' => 'horizontal-form message-form', 
                        'method' => 'put']) !!}
                        <input type="hidden" name="messages_id" id="messages_id_{{ $k }}" value="{{ $message->id }}">
                        @endif
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="languages_id" id="languages_id_{{ $k }}" value="{{ $language->id }}">
                                        <label class="control-label" for="name"><span class="required">* </span>Título</label>
                                        {!! Form::text('title', $is_create ? null : $language->pivot->title, ['class' => 'form-control', 'id' => 'name', 'autocomplete' => 'off'])!!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name"><span class="required">* </span>Asunto</label>
                                        {!! Form::text('subject', $is_create ? null : $language->pivot->subject, ['class' => 'form-control', 'id' => 'subject', 'autocomplete' => 'off'])!!}
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="message_body_{{ $k }}" style="height: 350px"></div>
                                    <input type="hidden" name="body" id="message_body_hidden_{{ $k }}" 
                                    value="{{ $is_create ? null : $language->pivot->body }}">
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

    setActiveTab();
});

//Set active tab from local storage
$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('message_active_tab', $(e.target).attr('href'));
    localStorage.setItem('from_message_index', false);
});
function setActiveTab() {
    
    let activeTab = localStorage.getItem('message_active_tab');
    let fromSuppIndex = localStorage.getItem('from_message_index');

    if(fromSuppIndex == 'false' && activeTab){
        $('#language_tabs a[href="' + activeTab + '"]').tab('show');
        let active_tab_id = activeTab.split('_')[1];
        initializeWYSIWYG(active_tab_id);
        setWYSIWYGContent(active_tab_id);
    } else {
        $('#language_tabs a[href="#tab_0_content"]').tab('show');
        let active_tab_id = $("#language_tabs li.active").attr('id').split('_')[1];

        initializeWYSIWYG(active_tab_id);
        setWYSIWYGContent(active_tab_id);
    }
}

$('.tab-anchor').click(function(){
    let active_tab_id = $(this).attr('id').split('_')[2];
    initializeWYSIWYG(active_tab_id);
    setWYSIWYGContent(active_tab_id);
});

function setWYSIWYGContent(active_tab_id) {
    let wysiwyg = document.querySelector('#message_body_' + active_tab_id);
    let content = $('#message_body_hidden_' + active_tab_id).val();
    wysiwyg.children[0].innerHTML = content;
}

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
    e.preventDefault();
    let active_tab_id = $("#language_tabs li.active").attr('id').split('_')[1];
    let wysiwyg = document.querySelector('#message_body_' + active_tab_id);
    let wysiwyg_content = wysiwyg.children[0].innerHTML;
    $('#message_body_hidden_' + active_tab_id).val(wysiwyg_content);

    let token = $('input[name=_token]').val();
    let serialized_form = $(this).serialize();
    
    let is_create = $('meta[name=is_create]').attr('content');
    let language_id = is_create ? '' : '/' + $('#languages_id_' + active_tab_id).val();
    
    $.ajax({
        url: '/message' + language_id,
        method: 'post',
        dataType: 'json',
        data: serialized_form,
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            if(response.errors)
                $('#error_messages').html(response.errors_fragment);
            else
                location = response.url;
        }
    });
});
</script>
@endpush