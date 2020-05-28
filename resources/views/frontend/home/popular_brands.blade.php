<section class="section pt-5 pb-5 products-section">
    <div class="container">
        <div class="section-header text-center">
            <h2>Popular Brands</h2>
            <p>Top restaurants, cafes, pubs, and bars in Ludhiana, based on trends</p>
            <span class="line"></span>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel owl-carousel-four owl-theme">
                    @foreach($shops as $shop)
                    <div class="item">
                        <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                            <div class="list-card-image">
                                <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                                <a href="/frontend/shop/{{$shop->id}}">
                                    @if($shop->logo == null)
                                        <img src="/images/noImg.png" class="img-fluid item-img">
                                    @else
                                        <img src="{{ asset('/images/shops/'.$shop->id.'/'.$shop->logo) }}" class="img-fluid item-img">
                                    @endif
                                </a>
                            </div>
                            <div class="p-3 position-relative">
                                <div class="list-card-body">
                                    <h6 class="mb-1"><a href="/frontend/shop/{{$shop->id}}" class="text-black">{{$shop->name}}</a></h6>
                                    <p class="text-gray mb-3">{{$shop->address}}</p>
                                    <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i class="icofont-wall-clock"></i> {{$shop->delivery_time}} min</span> <span class="float-right text-black-50"> Min {{$shop->min_price_order}}$</span></p>
                                </div>
                                <div class="list-card-badge">
                                  <small>{{$shop->description}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
