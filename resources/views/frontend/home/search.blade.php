
<section class="pt-5 pb-5 homepage-search-block position-relative" style="background-image: url('{{ asset('assets/images/background01.png') }}')">
    <div class="banner-overlay"></div>
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-md-12">
                <div class="homepage-search-title">
                    <h1 class="mb-2 font-weight-normal colorWhite"><span class="font-weight-bold">Find Awesome Deals</span> in Australia</h1>
                    <h5 class="mb-5 text-secondary font-weight-normal colorWhite" >Lists of top restaurants, cafes, pubs, and bars in Melbourne, based on trends</h5>
                </div>
                <div class="homepage-search-form">
                    <form method="post" action="{{ url('/frontend/shops') }}" >
                        {{csrf_field()}}
                        <div class="form-row">
                            <div class="col-lg-3 col-md-3 col-sm-12 form-group">
                                <div class="location-dropdown">
                                    <i class="icofont-location-arrow"></i>
                                    <select class="custom-select form-control-lg">
                                        <option @if($service=='pickup') selected @endif value="pickup">Pickup</option>
                                        <option @if($service=='pickup') selected @endif value="delivery">Delivery</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12 form-group">
                                <input type="text" list="search_id" id="search_id_input"
                                       @if(isset($location)) value="{{$location}}" @endif
                                       name="location" placeholder="What is your location?" class="form-control borderRadiusCircle" />
                                <datalist id="search_id">
                                    @foreach($cities as $city)
                                        <option value="{{$city->search_city}}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 form-group">
                                <button type="submit" class="btn btn-primary btn-block btn-lg btn-gradient">Search</button>
                                <!--<button type="submit" class="btn btn-primary btn-block btn-lg btn-gradient">Search</button>-->
                            </div>
                        </div>
                    </form>
                </div>
                <h6 class="mt-4 text-shadow font-weight-normal colorWhite" >E.g. Beverages, Pizzas, Chinese, Bakery, Indian...</h6>
                <div class="owl-carousel owl-carousel-category owl-theme">
                    <div class="item">
                        <div class="osahan-category-item">
                            <a href="#">
                                <img class="img-fluid" src="/new_front/img/list/1.png" alt="">
                                <h6>American</h6>
                                <p>156</p>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="osahan-category-item">
                            <a href="#">
                                <img class="img-fluid" src="/new_front/img/list/2.png" alt="">
                                <h6>Pizza</h6>
                                <p>120</p>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="osahan-category-item">
                            <a href="#">
                                <img class="img-fluid" src="/new_front/img/list/3.png" alt="">
                                <h6>Healthy</h6>
                                <p>130</p>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="osahan-category-item">
                            <a href="#">
                                <img class="img-fluid" src="/new_front/img/list/4.png" alt="">
                                <h6>Vegetarian</h6>
                                <p>120</p>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="osahan-category-item">
                            <a href="#">
                                <img class="img-fluid" src="/new_front/img/list/1.png" alt="">
                                <h6>Chinese</h6>
                                <p>111</p>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="osahan-category-item">
                            <a href="#">
                                <img class="img-fluid" src="/new_front/img/list/2.png" alt="">
                                <h6>Hamburgers</h6>
                                <p>958</p>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="osahan-category-item">
                            <a href="#">
                                <img class="img-fluid" src="/new_front/img/list/3.png" alt="">
                                <h6>Dessert</h6>
                                <p>56</p>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="osahan-category-item">
                            <a href="#">
                                <img class="img-fluid" src="/new_front/img/list/1.png" alt="">
                                <h6>Chicken</h6>
                                <p>40</p>
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="osahan-category-item">
                            <a href="#">
                                <img class="img-fluid" src="/new_front/img/list/4.png" alt="">
                                <h6>Indian</h6>
                                <p>156</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="osahan-slider pl-4 pt-3">
                    <div class="owl-carousel homepage-ad owl-theme">
                        <div class="item">
                            <a href="listing.html"><img class="img-fluid rounded" src="/new_front/img/slider.png"></a>
                        </div>
                        <div class="item">
                            <a href="listing.html"><img class="img-fluid rounded" src="/new_front/img/slider1.png"></a>
                        </div>
                        <div class="item">
                            <a href="listing.html"><img class="img-fluid rounded" src="/new_front/img/slider.png"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>