@extends('layouts.admin.master')
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('dashboard') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Configuración</span>
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
        <a href="{{ route('settings.edit') }}" class="btn btn-lg blue">Semáforo</a>
        <a href="{{ route('alert.index') }}" class="btn btn-lg blue">Alertas</a>
        <a href="{{ route('checklistauth.index') }}" class="btn btn-lg blue">Checklist Autorización</a>
        <a href="{{ route('selectlistauth.index') }}" class="btn btn-lg blue">Tipo de Segimiento</a>
    </div>
</div>
@endsection
@push('scripts')

<script type="text/javascript">
$(document).ready(function(){
    $('#sidebar_configuration').addClass('active');
});
</script>
@endpush