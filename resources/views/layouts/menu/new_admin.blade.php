<div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-dark">
    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <div class="app-brand demo">
            <span class="app-brand-logo demo">
                <a href="{{ url("/frontend") }}">
                <img src="{{ asset('new_front/img/logo.png') }}" alt="BITE ME" class="img-fluid"></a>
            </span>
        <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
            <i class="ion ion-md-menu align-middle"></i>
        </a>
    </div>
    <div class="sidenav-divider mt-0"></div>

    <!-- Links -->
    <ul class="sidenav-inner py-1">

        <!-- Dashboards -->
        <li class="sidenav-item">
            <a href="{{ url("/admin") }}" class="sidenav-link">
                <i class="sidenav-icon feather icon-home"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="sidenav-item">
            <a href="{{ url('admin/support') }}" class="sidenav-link">
                <i class="sidenav-icon fa fa-life-ring "></i>
                <div>Support</div>
            </a>
        </li>
        @if(CD::checkPermission('CuponManagement'))
            <li class="sidenav-item">
                <a href="{{ url('admin/cupons') }}" class="sidenav-link">
                    <i class="sidenav-icon fa fa-ticket-alt"></i>
                    <div>Coupons</div>
                </a>
            </li>
        @endif
        @if(CD::checkPermission('ShopManagement') || CD::checkPermission('ShopEditor') )
            <li class="sidenav-item">
                <a href="{{ url('admin/shops') }}" class="sidenav-link">
                    <i class="sidenav-icon fa fa-shopping-cart"></i>
                    <div>Shops</div>
                </a>
            </li>
        @endif
        @if(CD::checkPermission('OrderManagement'))
            <li class="sidenav-item">
                <a href="{{ url('admin/orders') }}" class="sidenav-link">
                    <i class="sidenav-icon feather icon-book"></i>
                    <div>Orders</div>
                </a>
            </li>
        @endif
        @if(CD::checkPermission('UserManagement') && auth()->user()->group_id==1)
            <li class="sidenav-divider mb-1"></li>
            <li class="sidenav-item">
                <a href="{{ url('admin/users') }}" class="sidenav-link">
                    <i class="sidenav-icon feather icon-user"></i>
                    <div>User Management</div>
                </a>
            </li>
            <li class="sidenav-item">
                <a href="{{ url('admin/user/assign') }}" class="sidenav-link">
                    <i class="sidenav-icon feather icon-unlock"></i>
                    <div>Assign Permission</div>
                </a>
            </li>
            <li class="sidenav-item">
                <a href="{{ url('admin/user/groups') }}" class="sidenav-link">
                    <i class="sidenav-icon feather icon-users"></i>
                    <div>Roles</div>
                </a>
            </li>
            <li class="sidenav-item">
                <a href="{{ url('admin/user/groups/function') }}" class="sidenav-link">
                    <i class="sidenav-icon feather icon-lock"></i>
                    <div>Permission</div>
                </a>
            </li>
        @endif
        @if(CD::checkPermission('Reporting'))
            <li class="sidenav-divider mb-1"></li>
            <li class="sidenav-item">
                <a href="{{ url('admin/report') }}" class="sidenav-link">
                    <i class="sidenav-icon fa fa-file"></i> <span class="title">Report</span>
                </a>
            </li>
    @endif
    </ul>
</div>