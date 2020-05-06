<nav class="navbar navbar-expand-lg navbar-light bg-light osahan-nav shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{!! url("/") !!}"><img alt="logo" src="/new_front/img/logo.png"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{!! url("/") !!}">Home</a>
                </li>
{{--                <li class="nav-item active">--}}
{{--                    <a class="nav-link" href="{!! url("/restaurants") !!}">Restaurants</a>--}}
{{--                </li>--}}
                <li class="nav-item active">
                    <a class="nav-link" href="{!! url("/contact") !!}">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img alt="Generic placeholder image" src="/new_front/img/user/4.png" class="nav-osahan-pic rounded-pill"> My Account
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                @if(!auth()->check())
                        <a class="nav-link"  href="{{ url('/register') }}">Join Now</a>
                        <a class="nav-link"  href="{{ url('/login') }}">Login</a>
                @else
                    @if(auth()->user()->group_id!=4 && auth()->user()->group_id!=7)
                            <a class="nav-link"  href="{{ url('/admin') }}">Admin</a>
                    @elseif(auth()->user()->group_id==4 || auth()->user()->group_id==7)
                            <a class="nav-link"  href="{{ url('/home') }}">Dashboard</a>
                    @endif
                        <a class="nav-link"  href="{{ url('/logout') }}">
                            Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </a>
            @endif
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-cart">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-basket"></i> Cart
                        <span class="badge badge-success">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-cart-top p-0 dropdown-menu-right shadow-sm border-0">
                        <div class="dropdown-cart-top-header p-4">
                            <img class="img-fluid mr-3" alt="osahan" src="/new_front/img/cart.jpg">
                            <h6 class="mb-0">Gus's World Famous Chicken</h6>
                            <p class="text-secondary mb-0">310 S Front St, Memphis, USA</p>
                            <small><a class="text-primary font-weight-bold" href="#">View Full Menu</a></small>
                        </div>
                        <div class="dropdown-cart-top-body border-top p-4">
                            <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> Chicken Tikka Sub 12" (30 cm) x 1   <span class="float-right text-secondary">$314</span></p>
                            <p class="mb-2"><i class="icofont-ui-press text-success food-item"></i> Corn & Peas Salad x 1   <span class="float-right text-secondary">$209</span></p>
                            <p class="mb-2"><i class="icofont-ui-press text-success food-item"></i> Veg Seekh Sub 6" (15 cm) x 1  <span class="float-right text-secondary">$133</span></p>
                            <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> Chicken Tikka Sub 12" (30 cm) x 1   <span class="float-right text-secondary">$314</span></p>
                            <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> Corn & Peas Salad x 1   <span class="float-right text-secondary">$209</span></p>
                        </div>
                        <div class="dropdown-cart-top-footer border-top p-4">
                            <p class="mb-0 font-weight-bold text-secondary">Sub Total <span class="float-right text-dark">$499</span></p>
                            <small class="text-info">Extra charges may apply</small>
                        </div>
                        <div class="dropdown-cart-top-footer border-top p-2">
                            <a class="btn btn-success btn-block btn-lg" href="checkout.html"> Checkout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>