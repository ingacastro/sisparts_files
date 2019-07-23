<head>
    <meta charset="utf-8" />
    <title>International Parts</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="InternationalParts" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="/metronic-assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/metronic-assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/metronic-assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/metronic-assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="/metronic-assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="/metronic-assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="/metronic-assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="/metronic-assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="/metronic-assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/metronic-assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="/metronic-assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="/metronic-assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="/metronic-assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="/favicon.ico" />
    <meta id="root_url" content="{{ config('app.url') }}">
    @yield('meta-css')
    <style>
        .page-sidebar-menu { padding-top: 44px !important; }
        .page-title { color: #e7505a!important; font-weight: normal; }
        #user_data:hover { background-color: transparent !important; cursor: default !important; }
        .modal-xl {
            width: 95%;
        }
        .modal-xl .modal-body {
            padding-bottom: 0px !important;
        }
        .modal-content-border {
            border: 1px solid #869ab3;
            border-radius: 4px;
            padding-top: 10px;
            margin-left: -5px !important;
            margin-right: -5px !important;
        }
    </style>
</head>