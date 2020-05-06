
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar" id="main-menu">
    <!-- BEGIN MINI-PROFILE -->
    <div class="page-sidebar-wrapper scrollbar-dynamic" id="main-menu-wrapper">

        <!-- BEGIN SIDEBAR MENU -->
        <p class="menu-title">Navigation</p>
        <ul>
            <li class="start">
                <a href="{{ url('admin') }}">
                    <i class="icon-custom-home"></i> <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/support') }}">
                    <i class="fa fa-life-ring"></i> <span class="title">Support</span>
                </a>
            </li>
        @if(CD::checkPermission('CuponManagement'))
            <li>
                <a href="{{ url('admin/cupons') }}">
                    <i class="fas fa-ticket-alt"></i> <span class="title">Cupons</span>
                </a>
            </li>
        @endif
        @if(CD::checkPermission('ShopManagement') || CD::checkPermission('ShopEditor') )
                <li>
                    <a href="{{ url('admin/shops') }}">
                        <i class="fab fa-servicestack"></i> <span class="title">Shops</span>
                    </a>
                </li>
        @endif
        @if(CD::checkPermission('OrderManagement'))
                <li>
                    <a href="{{ url('admin/orders') }}">
                        <i class="fab fa-first-order"></i> <span class="title">Orders</span>
                    </a>
                </li>
        @endif
        @if(CD::checkPermission('UserManagement') && auth()->user()->group_id==1)
                <li>
                    <span class="title"><hr style="border-bottom:0;border-color:#888;"/></span>
                </li>
                <li>
                    <a href="{{ url('admin/users') }}">
                        <i class="fa fa-user"></i> <span class="title">User Management</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('admin/user/assign') }}">
                        <i class="fa fa-unlock"></i> <span class="title">Assign Permission</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('admin/user/groups') }}">
                        <i class="fa fa-users"></i> <span class="title">Roles</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('admin/user/groups/function') }}">
                        <i class="fa fa-lock"></i> <span class="title">Permission</span>
                    </a>
                </li>
        @endif
        @if(CD::checkPermission('Reporting'))
                <li>
                    <span class="title"><hr style="border-bottom:0;border-color:#888;"/></span>
                </li>
                <li>
                    <a href="{{ url('admin/report') }}">
                        <i class="fa fa-file"></i> <span class="title">Report</span>
                    </a>
                </li>
        @endif
            </ul>
        <div class="clearfix"></div>
        <!-- END SIDEBAR MENU -->
    </div>
</div>