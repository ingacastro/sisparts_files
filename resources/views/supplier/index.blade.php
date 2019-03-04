@extends('layouts.admin.master')
@section('meta-css')
<link href="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@section('breadcumb')
<ul class="page-breadcrumb">
    <li>
        <a href="{{ route('home') }}">Home</a>
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
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <a href="{{ route('supplier.create') }}" class="btn green"> Nuevo
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered" id="suppliers_table">
                    <thead>
                        <tr>
                            <th> Username </th>
                            <th> Full Name </th>
                            <th> Points </th>
                            <th> Notes </th>
                            <th> Edit </th>
                            <th> Delete </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> alex </td>
                            <td> Alex Nilson </td>
                            <td> 1234 </td>
                            <td class="center"> power user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> lisa </td>
                            <td> Lisa Wong </td>
                            <td> 434 </td>
                            <td class="center"> new user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> lisa </td>
                            <td> Lisa Wong </td>
                            <td> 434 </td>
                            <td class="center"> new user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> lisa </td>
                            <td> Lisa Wong </td>
                            <td> 434 </td>
                            <td class="center"> new user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> lisa </td>
                            <td> Lisa Wong </td>
                            <td> 434 </td>
                            <td class="center"> new user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> nick12 </td>
                            <td> Nick Roberts </td>
                            <td> 232 </td>
                            <td class="center"> power user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> goldweb </td>
                            <td> Sergio Jackson </td>
                            <td> 132 </td>
                            <td class="center"> elite user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> alex </td>
                            <td> Alex Nilson </td>
                            <td> 1234 </td>
                            <td class="center"> power user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> webriver </td>
                            <td> Antonio Sanches </td>
                            <td> 462 </td>
                            <td class="center"> new user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> gist124 </td>
                            <td> Nick Roberts </td>
                            <td> 62 </td>
                            <td class="center"> new user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                        <tr>
                            <td> alex </td>
                            <td> Alex Nilson </td>
                            <td> 1234 </td>
                            <td class="center"> power user </td>
                            <td>
                                <a class="edit" href="javascript:;"> Edit </a>
                            </td>
                            <td>
                                <a class="delete" href="javascript:;"> Delete </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endsection
@endsection
@push('scripts')
<script src="/metronic-assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/metronic-assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sidebar_supplier').addClass('active');
        $('#suppliers_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });
    });
</script>
@endpush
