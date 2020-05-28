<!DOCTYPE html>
<html lang="en" class="material-style layout-fixed">
<head>
    <title>Mealnow</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="author" content="Uncredited" />
    <link rel="icon" type="image/x-icon" href="/new_backend_assets/assets/img/favicon.ico">

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Icon fonts -->
    <link rel="stylesheet" href="/new_backend_assets/assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="/new_backend_assets/assets/fonts/ionicons.css">
    <link rel="stylesheet" href="/new_backend_assets/assets/fonts/linearicons.css">
    <link rel="stylesheet" href="/new_backend_assets/assets/fonts/open-iconic.css">
    <link rel="stylesheet" href="/new_backend_assets/assets/fonts/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="/new_backend_assets/assets/fonts/feather.css">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="/new_backend_assets/assets/css/bootstrap-material.css">
    <link rel="stylesheet" href="/new_backend_assets/assets/css/shreerang-material.css">
    <link rel="stylesheet" href="/new_backend_assets/assets/css/uikit.css">
    @yield('head')
    <!-- Libs -->
    <link rel="stylesheet" href="/new_backend_assets/assets/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/new_backend_assets/assets/libs/flot/flot.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">


</head>

<body>
<!-- [ Preloader ] Start -->
<div class="page-loader">
    <div class="bg-primary"></div>
</div>
<!-- [ Preloader ] End -->
<!-- [ Layout wrapper ] Start -->
<div class="layout-wrapper layout-2">
    <div class="layout-inner">
        <!-- [ Layout sidenav ] Start -->

        @include('layouts.menu.new_admin')
        <!-- [ Layout sidenav ] End -->
        <!-- [ Layout container ] Start -->
        <div class="layout-container">
            <!-- [ Layout navbar ( Header ) ] Start -->
            <nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center text-white bg-white container-p-x" style="background-color: #ff000cc7  !important;" id="layout-navbar">

                <!-- Sidenav toggle (see assets/css/demo/demo.css) -->
                <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
                    <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
                        <i class="ion ion-md-menu text-large align-middle"></i>
                    </a>
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                    <!-- Divider -->
                    <hr class="d-lg-none w-100 my-2">
                    <div class="navbar-nav align-items-lg-center">
                    </div>

                    <div class="navbar-nav align-items-lg-center ml-auto">
                        <!-- Divider -->
                        <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
                        <div class="demo-navbar-user nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                                        <span class="px-1 mr-lg-2 ml-2 ml-lg-0 text-white">{{auth()->user()->name}}</span>
                                    </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
{{--                                <a href="javascript:" class="dropdown-item">--}}
{{--                                    <i class="feather icon-settings text-muted"></i> &nbsp; My Orders--}}
{{--                                </a>--}}
{{--                                <div class="dropdown-divider"></div>--}}
                                <a href="{!! url('logout') !!}" class="dropdown-item">
                                    <i class="feather icon-power text-danger"></i> &nbsp; Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- [ Layout navbar ( Header ) ] End -->

            <!-- [ Layout content ] Start -->
            <div class="layout-content">
            @yield('content')
                <!-- [ content ] Start -->
            </div>
            <!-- [ Layout content ] Start -->
        </div>
        <!-- [ Layout container ] End -->
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-sidenav-toggle"></div>
</div>
<!-- [ Layout wrapper] End -->

<!-- Core scripts -->
<script src="/new_backend_assets/assets/js/pace.js"></script>
<script src="/new_backend_assets/assets/js/jquery-3.3.1.min.js"></script>
<script src="/new_backend_assets/assets/libs/popper/popper.js"></script>
<script src="/new_backend_assets/assets/js/bootstrap.js"></script>
<script src="/new_backend_assets/assets/js/sidenav.js"></script>
<script src="/new_backend_assets/assets/js/layout-helpers.js"></script>
<script src="/new_backend_assets/assets/js/material-ripple.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!-- Libs -->
<script src="/new_backend_assets/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="/new_backend_assets/assets/libs/eve/eve.js"></script>
<script src="/new_backend_assets/assets/libs/flot/flot.js"></script>
<script src="/new_backend_assets/assets/libs/flot/curvedLines.js"></script>
<script src="/new_backend_assets/assets/libs/chart-am4/core.js"></script>
<script src="/new_backend_assets/assets/libs/chart-am4/charts.js"></script>
<script src="/new_backend_assets/assets/libs/chart-am4/animated.js"></script>

<!-- Demo -->
{{--<script src="/new_backend_assets/assets/js/demo.js"></script>--}}
<script src="assets/js/analytics.js"></script>
<script src="/new_backend_assets/assets/js/pages/dashboards_index.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
@yield('footer')
<script>
    $(document).ready( function () {
        $('.myTable').DataTable();
    } );
</script>

</body>
</html>
