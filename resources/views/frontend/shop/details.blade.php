<section class="restaurant-detailed-banner" style="height:300px;">
    <div class="text-center">
        @if(file_exists(asset('/images/shops/'.$shop->id.'/'.$shop->logo) )>1)
            <img src="{{ asset('/images/shops/'.$shop->id.'/'.$shop->logo) }}"/>
        @else
            <img src="{{ asset('/assets/img/noimage.jpg') }}"/>
        @endif
    </div>
    <div class="restaurant-detailed-header">
        <div class="container">
            <div class="row d-flex align-items-end">
                <div class="col-md-8">
                    <div class="restaurant-detailed-header-left">
                       @if(file_exists(asset('/images/shops/'.$shop->id.'/'.$shop->logo) )>1)
                            <img src="{{ asset('/images/shops/'.$shop->id.'/'.$shop->logo) }}"/>
                        @else
                            <img src="{{ asset('/assets/img/noimage.jpg') }}"/>
                        @endif
                           <input type="hidden" id="minimum_delivery_price_to_check" value="{{ $shop->min_price_order }}" />
                        <h2 class="text-white">{{ $shop->name }}</h2>
                        <p class="text-white mb-1"><i class="icofont-location-pin"></i> {!! $shop->address !!}
                                 @if($shop->isOpen)
                                <span class="badge badge-success"> OPEN</span>
                                @else
                                <span class="badge badge-danger"> <strong>Closed</strong> </span>
                                @endif
                        </p>
                        <p class="text-white mb-0" style="float: left;"><i class="icofont-food-cart"></i>
                           <ul class=" nav" style="padding:0 5px;margin:0 5px;">
                               <li class="text-white"> <i class="fa fa-check"></i> Min {{ $shop->min_price_order }}&pound; </li>
                               <li class="text-white">&nbsp;&nbsp; <i class="fa fa-motorcycle"></i> {{ $shop->delivery_time }} min </li>
                           </ul>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="restaurant-detailed-header-right text-right">
                         @if($shop->isOpen)
                            <button class="btn btn-success" type="button"><i class="icofont-clock-time"></i> {{$shop->openTill}}   </button>
                            @else
                            <button class="btn btn-danger" type="button"><i class="icofont-clock-time"></i> <strong>Currently Closed</strong> </button>
                            @endif

                        <h6 class="text-white mb-0 restaurant-detailed-ratings">
                            • <a href="#" style="color:cyan" data-toggle="modal" data-target="#viewFullHours">View full hours</a>
                            • <strong>{{ $shop->delivery_price }}&pound; Delivery</strong>
                        </h6>
                            <div class="modal fade" id="viewFullHours" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Hours</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body" style="padding:30px;">
                                            <?php $days = json_decode($shop->working_hours, true); ?>
                                            <table class="table" style="border:none;">
                                                @if(count($days)>0)
                                                    @foreach($days as $day => $hours)
                                                        <tr>
                                                            <td style="padding: 5px;border:none !important;color:black!important;"><strong>{{ ucfirst($day) }}</strong>:</td>
                                                            <td style="padding: 5px;border:none !important;color:black!important;">{{$hours['hours_from']}} - {{$hours['hours_to']}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="offer-dedicated-body pt-2 pb-2 mt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="offer-dedicated-body-left">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-order-online" role="tabpanel" aria-labelledby="pills-order-online-tab">
                            <div class="row">
                                @php $i=0;foreach($menu['items'] as $item) if($item != null) $i++; @endphp
                                <h5 class="mb-4 mt-3 col-md-12">Menu <small class="h6 text-black-50">{!! $i !!} ITEM(S)</small></h5>
                                <div class="col-md-12">
                                    <div class="bg-white rounded border shadow-sm mb-4">
                                        @include('frontend.shop.menu.menu')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" >
                @include('frontend.shop.cart.cart')
            </div>
        </div>
    </div>
</section>
