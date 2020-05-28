@extends('layouts.master')


@section('content')
    <!-- top Links -->
    <div class="top-links">
            <div class="container">

            </div>
        </div>
    <section class="breadcrumb-osahan pt-5 pb-5 bg-dark position-relative text-center">
        <ul class="row links text-white" style="text-decoration: none;list-style: none;">
            <li class="col-xs-12 col-sm-3 link-item"><span>1 </span><a href="/">Choose Your Location</a></li>
            <li class="col-xs-12 col-sm-3 link-item active"><span>2 </span><a href="#">Choose Restaurant</a></li>
            <li class="col-xs-12 col-sm-3 link-item" ><span>3 </span><a href="#">Pick Your favorite food</a></li>
            <li class="col-xs-12 col-sm-3 link-item" ><span>4 </span><a href="#">Order and Pay online</a></li>
        </ul>
    </section>
             <!-- //results show -->
    <section class="section pt-5 pb-5 products-listing">
        <div class="container">
            <div class="row d-none-m">
                <div class="col-md-12">
{{--                    <div class="dropdown float-right">--}}
{{--                        <a class="btn btn-outline-info dropdown-toggle btn-sm border-white-btn" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            Sort by: <span class="text-theme">Distance</span> &nbsp;&nbsp;--}}
{{--                        </a>--}}
{{--                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0 ">--}}
{{--                            <a class="dropdown-item" href="#">Distance</a>--}}
{{--                            <a class="dropdown-item" href="#">No Of Offers</a>--}}
{{--                            <a class="dropdown-item" href="#">Rating</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <h4 class="font-weight-bold mt-0 mb-3">Shops <small class="h6 mb-0 ml-2">{!! count($shops) !!} results
                        </small>
                    </h4>
                </div>
            </div>
            <div class="row">
{{--                <div class="col-md-3">--}}
{{--                    <div class="filters shadow-sm rounded bg-white mb-4">--}}
{{--                        <div class="filters-header border-bottom pl-4 pr-4 pt-3 pb-3">--}}
{{--                            <h5 class="m-0">Filter By</h5>--}}
{{--                        </div>--}}
{{--                        <div class="filters-body">--}}
{{--                            <div id="accordion">--}}
{{--                                <div class="filters-card border-bottom p-4">--}}
{{--                                    <div class="filters-card-header" id="headingOne">--}}
{{--                                        <h6 class="mb-0">--}}
{{--                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">--}}
{{--                                                Location <i class="icofont-arrow-down float-right"></i>--}}
{{--                                            </a>--}}
{{--                                        </h6>--}}
{{--                                    </div>--}}
{{--                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">--}}
{{--                                        <div class="filters-card-body card-shop-filters">--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb1">--}}
{{--                                                <label class="custom-control-label" for="cb1">Ludhiana Junction <small class="text-black-50">230</small>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb2">--}}
{{--                                                <label class="custom-control-label" for="cb2">Model Town <small class="text-black-50">95</small>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb3">--}}
{{--                                                <label class="custom-control-label" for="cb3">Civil Lines <small class="text-black-50">35</small>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb4">--}}
{{--                                                <label class="custom-control-label" for="cb4">Dugri <small class="text-black-50">46</small>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb5">--}}
{{--                                                <label class="custom-control-label" for="cb5">PAU <small class="text-black-50">20</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="mt-2"><a href="#" class="link">See all</a></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="filters-card border-bottom p-4">--}}
{{--                                    <div class="filters-card-header" id="headingTwo">--}}
{{--                                        <h6 class="mb-0">--}}
{{--                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">--}}
{{--                                                All cuisines--}}
{{--                                                <i class="icofont-arrow-down float-right"></i>--}}
{{--                                            </a>--}}
{{--                                        </h6>--}}
{{--                                    </div>--}}
{{--                                    <div id="collapsetwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">--}}
{{--                                        <div class="filters-card-body card-shop-filters">--}}
{{--                                            <form class="filters-search mb-3">--}}
{{--                                                <div class="form-group">--}}
{{--                                                    <i class="icofont-search"></i>--}}
{{--                                                    <input type="text" class="form-control" placeholder="Start typing to search...">--}}
{{--                                                </div>--}}
{{--                                            </form>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb6">--}}
{{--                                                <label class="custom-control-label" for="cb6">American <small class="text-black-50">156</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb7">--}}
{{--                                                <label class="custom-control-label" for="cb7">Pizza <small class="text-black-50">120</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb8">--}}
{{--                                                <label class="custom-control-label" for="cb8">Healthy <small class="text-black-50">130</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb9">--}}
{{--                                                <label class="custom-control-label" for="cb9">Vegetarian <small class="text-black-50">120</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb10">--}}
{{--                                                <label class="custom-control-label" for="cb10"> Chinese <small class="text-black-50">111</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb11">--}}
{{--                                                <label class="custom-control-label" for="cb11"> Hamburgers <small class="text-black-50">95</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb12">--}}
{{--                                                <label class="custom-control-label" for="cb12"> Dessert <small class="text-black-50">50</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb13">--}}
{{--                                                <label class="custom-control-label" for="cb13"> Chicken <small class="text-black-50">32</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb14">--}}
{{--                                                <label class="custom-control-label" for="cb14"> Indian <small class="text-black-50">156</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="mt-2"><a href="#" class="link">See all</a></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="filters-card border-bottom p-4">--}}
{{--                                    <div class="filters-card-header" id="headingCategory">--}}
{{--                                        <h6 class="mb-0">--}}
{{--                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseFeature" aria-expanded="true" aria-controls="collapseFeature">--}}
{{--                                                Feature <i class="icofont-arrow-down float-right"></i>--}}
{{--                                            </a>--}}
{{--                                        </h6>--}}
{{--                                    </div>--}}
{{--                                    <div id="collapseFeature" class="collapse" aria-labelledby="headingCategory" data-parent="#accordion">--}}
{{--                                        <div class="filters-card-body card-shop-filters">--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb15">--}}
{{--                                                <label class="custom-control-label" for="cb15">Free Delivery <small class="text-black-50">156</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb26">--}}
{{--                                                <label class="custom-control-label" for="cb26">Coupons <small class="text-black-50">120</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb37">--}}
{{--                                                <label class="custom-control-label" for="cb37">Open Now [1:31am] <small class="text-black-50">85</small>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="filters-card border-bottom p-4">--}}
{{--                                    <div class="filters-card-header" id="headingOffer">--}}
{{--                                        <h6 class="mb-0">--}}
{{--                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseOffer" aria-expanded="true" aria-controls="collapseOffer">--}}
{{--                                                Delivery time <i class="icofont-arrow-down float-right"></i>--}}
{{--                                            </a>--}}
{{--                                        </h6>--}}
{{--                                    </div>--}}
{{--                                    <div id="collapseOffer" class="collapse" aria-labelledby="headingOffer" data-parent="#accordion">--}}
{{--                                        <div class="filters-card-body card-shop-filters">--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb19">--}}
{{--                                                <label class="custom-control-label" for="cb19">Any Time </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb20">--}}
{{--                                                <label class="custom-control-label" for="cb20">25 min--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb36">--}}
{{--                                                <label class="custom-control-label" for="cb36">30 min--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb47">--}}
{{--                                                <label class="custom-control-label" for="cb47">40 min--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb58">--}}
{{--                                                <label class="custom-control-label" for="cb58">50 min--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="mt-2"><a href="#" class="link">See all</a></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="filters-card p-4">--}}
{{--                                    <div class="filters-card-header" id="headingCategory">--}}
{{--                                        <h6 class="mb-0">--}}
{{--                                            <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">--}}
{{--                                                Category <i class="icofont-arrow-down float-right"></i>--}}
{{--                                            </a>--}}
{{--                                        </h6>--}}
{{--                                    </div>--}}
{{--                                    <div id="collapseCategory" class="collapse" aria-labelledby="headingCategory" data-parent="#accordion">--}}
{{--                                        <div class="filters-card-body card-shop-filters">--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb15">--}}
{{--                                                <label class="custom-control-label" for="cb15">Delivery <small class="text-black-50">156</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb26">--}}
{{--                                                <label class="custom-control-label" for="cb26">Dine-out <small class="text-black-50">120</small></label>--}}
{{--                                            </div>--}}
{{--                                            <div class="custom-control custom-checkbox">--}}
{{--                                                <input type="checkbox" class="custom-control-input" id="cb37">--}}
{{--                                                <label class="custom-control-label" for="cb37">Cafés<small class="text-black-50">85</small>--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="filters pt-2">--}}
{{--                        <div class="filters-body rounded shadow-sm bg-white">--}}
{{--                            <div class="filters-card p-4">--}}
{{--                                <div>--}}
{{--                                    <div class="filters-card-body card-shop-filters pt-0">--}}
{{--                                        <div class="custom-control custom-radio">--}}
{{--                                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" checked="">--}}
{{--                                            <label class="custom-control-label" for="customRadio1">Gold Partner</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="custom-control custom-radio mt-1 mb-1">--}}
{{--                                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">--}}
{{--                                            <label class="custom-control-label" for="customRadio2">Order Food Online</label>--}}
{{--                                        </div>--}}
{{--                                        <div class="custom-control custom-radio">--}}
{{--                                            <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input" checked="">--}}
{{--                                            <label class="custom-control-label" for="customRadio3">Osahan Eat</label>--}}
{{--                                        </div>--}}
{{--                                        <hr>--}}
{{--                                        <small class="text-success">Use code OSAHAN50 to get 50% OFF (up to $30) on first 5 orders. T&Cs apply.</small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-12">
                    <div class="row">
                        @foreach($shops as $item)
                        <div class="col-md-4 col-sm-6 mb-4 pb-2">
                            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                <div class="list-card-image" style="text-align: center;">
                                    <a href="{{ url('frontend/shop/'.$item->id) }}">
                                        <img src="{{ asset('/images/shops/'.$item->id.'/'.$item->logo) }}" onerror="this.src='{{ asset('/assets/img/noimage.jpg') }}'"  class='img-fluid' style="margin:0 auto;max-width:100%;height:160px;">
                                    </a>
                                </div>
                                <div class="p-3 position-relative">
                                    <div class="list-card-body">
                                        <h6 class="mb-1"><a href="/frontend/shop/{{$item->id}}" class="text-black">{!! $item->name !!}</a></h6>
                                        <p class="text-gray mb-3">{{$item->address}}</p>
                                        <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i class="icofont-wall-clock"></i>
                                                @if($item->isOpen)
                                                    <label>Open till &nbsp;{{$item->openTill}}</label>
                                                @else
                                                    <label class="text text-danger text-center">Currently Closed</label>
                                                @endif</span></p>
                                    </div>
                                    <div class="list-card-badge">
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><i class="fa fa-check"></i> Minimum order price: {{$item->min_price_order}} $</li>
                                            <li class="list-inline-item"><i class="fa fa-motorcycle"></i> Delivery Time (minutes): {{$item->delivery_time}}</li>
                                            <li class="list-inline-item"><i class="fa fa-money"></i> Delivery Price : {{$item->delivery_price}}$</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        <!-- end:Restaurant entry -->
                        </div>
                        @endforeach
                            @if(count($shops)<=0)
                                <div class="col-md-12 text-center" style="padding-top:50px;">
                                    <span class="btn btn-danger btn-sm">There are no restaurants in searched area.</span>
                                </div>
                            @endif
{{--                        <div class="col-md-12 text-center load-more">--}}
{{--                            <button class="btn btn-primary" type="button" disabled>--}}
{{--                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>--}}
{{--                                Loading...--}}
{{--                            </button>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection
