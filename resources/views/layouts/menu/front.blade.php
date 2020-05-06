
<div class="lp-header-overlay"></div> <!-- ../header-overlay -->

<nav class="navbar navbar-dark" style=" margin:0%">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 mobile-nav-icon">
                <a href="#menu" class="nav-icon">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 lp-menu-container">

                <div class="col-md-8 col-sm-8 text-left">
                    <ul class="lp-topbar-menu">
                        <li>
                            <a href="{{ url('/frontend') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}">About</a>
                        </li>
                        <li>
                            <a href="{{ url('/contact') }}">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-4 text-right">

                    <ul class="lp-topbar-menu">
                        @if(!auth()->check())
                        <li>
                            <a href="{{ url('/register') }}">Join Now</a>
                        </li>
                        <li>
                            <a href="{{ url('/login') }}">Login</a>
                        </li>
                        @else
                            @if(auth()->user()->group_id!=4 && auth()->user()->group_id!=7)
                            <li>
                                <a href="{{ url('/admin') }}">Admin</a>
                            </li>
                            @elseif(auth()->user()->group_id==4 || auth()->user()->group_id==7)
                                <li>
                                    <a href="{{ url('/home') }}">Dashboard</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ url('/logout') }}">
                                    Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </div>
</nav>
<div id="menu" class="hidden-md hidden-lg mm-menu mm-offcanvas mm-hasnavbar-top-3 mm-current mm-opened" style="display: block;">
    <div class="mm-panels">
        <div class="mm-panel mm-opened mm-current" id="mm-1">
            <ul class="mm-listview">
                <li>
                    <a href="{{ url('/frontend') }}">
                        <i class="fa fa-home" aria-hidden="true"></i> Home
                    </a>
                </li>
                <li>
                    <a href="{{ url('/about') }}">
                        <i class="fa fa-info-circle" aria-hidden="true"></i> About
                    </a>
                </li>
                <li>
                    <a href="{{ url('/contact') }}">
                        <i class="fa fa-envelope" aria-hidden="true"></i> Contact
                    </a>
                </li>
                @if(!auth()->check())
                    <li>
                        <a class=" md-trigger" href="{{ url('/register') }}">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Join Now
                        </a>
                    </li>
                @else
                    <li>
                        <a class="md-trigger" href="{{ url('/admin') }}">
                            <i class="fa fa-user-o" aria-hidden="true"></i> Admin
                        </a>
                    </li>
                    <li>
                        <a class="md-trigger" href="{{ url('/logout') }}">
                            <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    </div>