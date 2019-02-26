@extends('layouts.admin.master')
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="index.html">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span>Proveedores</span>
    </li>
</ul>
@endsection
@section('page-title')
<h1 class="page-title"> Proveedores
    <small></small>
</h1>
@endsection
@section('page-content')
<div class="row">
    DataTable
</div>
@endsection
@endsection
@push('scripts')
<script type="text/javascript">
    $('#sidebar_supplier').addClass('active');
</script>
@endpush
