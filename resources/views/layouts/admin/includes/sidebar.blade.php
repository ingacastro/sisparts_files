<div class="page-sidebar-wrapper">
<!-- BEGIN SIDEBAR -->
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler">
                <span></span>
            </div>
        </li>
        <?php $user = Auth::user() ?>
        @if($user->hasPermissionTo('dashboard') || $user->hasRole('Administrador'))
        <li id="sidebar_dashboard" class="nav-item start">
            <a href="{{ route('dashboard') }}" class="nav-link nav-toggle">
                <i class="icon-bar-chart"></i>
                <span class="title">Tablero</span>
                <span class="selected"></span>
            </a>
        </li>
        <li id="sidebar_supplier" class="nav-item ">
            <a href="{{ route('supplier.index') }}" class="nav-link nav-toggle">
                <i class="icon-basket"></i>
                <span class="title">Proveedores</span>
                <span class="selected"></span>
            </a>
        </li>
        @endif
        @if($user->hasRole('Cotizador') || $user->hasRole('Administrador'))
        <li id="sidebar_inbox" class="nav-item ">
            <a href="{{ route('inbox.index') }}" class="nav-link nav-toggle">
                <i class="icon-envelope-open"></i>
                <span class="title">Bandeja de entrada</span>
                <span class="selected"></span>
            </a>
        </li>
        <li id="sidebar_archive" class="nav-item ">
            <a href="{{ route('archive.index') }}" class="nav-link nav-toggle">
                <i class="fa fa-archive"></i>
                <span class="title">Archivo</span>
                <span class="selected"></span>
            </a>
        </li>
        @endif
        @role('Administrador')
        <li id="sidebar_user" class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link nav-toggle">
                <i class="icon-user"></i>
                <span class="title">Usuarios</span>
                <span class="selected"></span>
            </a>
        </li>
        <li id="sidebar_message" class="nav-item">
            <a href="{{ route('message.index') }}" class="nav-link nav-toggle">
                <i class="icon-envelope"></i>
                <span class="title">Mensajes</span>
                <span class="selected"></span>
            </a>
        </li>
        <li id="sidebar_report" class="nav-item">
            <a href="{{ route('report.index') }}" class="nav-link nav-toggle">
                <i class="fa fa-file-excel-o"></i>
                <span class="title">Reporte</span>
                <span class="selected"></span>
            </a>
        </li>
        <li id="sidebar_configuration" class="nav-item">
            <a href="{{ route('configuration.index') }}" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">Configuración</span>
                <span class="selected"></span>
            </a>
        </li>
        <li id="sidebar_rejection_reason" class="nav-item">
            <a href="{{ route('rejection-reason.index') }}" class="nav-link nav-toggle">
                <i class="fa fa-ban"></i>
                <span class="title">Motivos de rechazo</span>
                <span class="selected"></span>
            </a>
        </li>
        @endrole
        <li id="sidebar_supply" class="nav-item">
            <a href="{{ route('supply.index') }}" class="nav-link nav-toggle">
                <i class="fa fa-truck"></i>
                <span class="title">Productos</span>
                <span class="selected"></span>
            </a>
        </li>
    </ul>
    <!-- END SIDEBAR MENU -->
    <!-- END SIDEBAR MENU -->
</div>