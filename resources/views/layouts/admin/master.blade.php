<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.7
Version: 4.7.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    @include('layouts.admin.includes.meta')
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <div class="page-header navbar navbar-fixed-top">
                <!-- BEGIN HEADER INNER -->
                <div class="page-header-inner ">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="{{ route('dashboard') }}">
                            <img src="/metronic-assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" /> </a>
                        <div class="menu-toggler sidebar-toggler">
                            <span></span>
                        </div>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                        <span></span>
                    </a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
                            <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                            <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                            <li>
                                <a id="user_data">
                                    {{-- <i class="icon-bell"></i> --}}
                                    <?php $user = Auth::user() ?>
                                    <span class="badge"><strong>{{ $user->roles->first()->name }}</strong></span>
                                    @if(isset($user->employee))
                                    <span class="badge">
                                        <strong>Número: {{ $user->employee->number}}</strong>
                                    </span>
                                    @endif
                                </a>
                            </li>
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    {{-- <img alt="" class="img-circle" src="/metronic-assets/layouts/layout/img/avatar3_small.jpg" /> --}}
                                    <span class="username username-hide-on-mobile" style="color: #ffffff">{{ $user->name }}</span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="{{ route('logout') }}">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END HEADER INNER -->
            </div>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                @include('layouts.admin.includes.sidebar')
                <!-- END SIDEBAR -->
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            @yield('breadcumb')
                        </div>
                        @yield('page-title')
                        @yield('page-content')
                    </div>
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            @include('layouts.admin.includes.footer')
            <!-- END FOOTER -->
        </div>
        <!--[if lt IE 9]>
<script src="/metronic-assets/global/plugins/respond.min.js"></script>
<script src="/metronic-assets/global/plugins/excanvas.min.js"></script> 
<script src="/metronic-assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="/metronic-assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="/metronic-assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="/metronic-assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="/metronic-assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="/metronic-assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="/metronic-assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="/metronic-assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        @stack('scripts')
    </body>
</html>