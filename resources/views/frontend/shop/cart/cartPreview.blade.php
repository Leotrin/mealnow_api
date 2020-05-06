<div class="col-md-12 p0" id="addToCart" style="background: #fafafa;color:#383838;">
    <div class="col-md-12 p10" style="border-bottom:1px solid #9d1e1f;color:#d12829;">
        <h6 style="font-size:16px">Your shopping cart.</h6>
        <hr style="margin:5px;" />
        <div style="width:100%;padding:0;font-size:12pt;color:#000;" id="delivery">
            <strong>
                <span id="serviceTime" class="serviceTime">
                    @if($schedule['time']=='now')
                        @if(!$shop->isOpen)
                            (currently closed) -
                        @else
                            ASAP
                        @endif
                    @else
                        {{ date('d-m-Y H:i', strtotime($schedule['date'])) }}
                    @endif
                </span>
                <span id="serviceType" style="text-transform: capitalize;"></span>
            </strong>
            <script>
                $(document).ready(function(){
                    $('#serviceType').html('{{$schedule['service']}}');
                });
            </script>
        </div>

        <div style="width:100%;padding:0;@if($schedule['service']=='pickup') display:none; @endif" class="deliveryAddress">
            @if($schedule!=null && $schedule['address']!='' && $schedule['name'] != '')
                <strong style="font-size:10pt;color:#000;" id="nameForDelivery">
                    {{ $schedule['name'] }}
                </strong>
                <br/>
                <strong style="font-size:10pt;color:#000;" id="addressForDelivery">
                    {{ $schedule['address'] }}
                </strong>
                <br />
            @endif

        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 p5" style="overflow-y: scroll;background: #efefef;min-height:200px;" id="myShoppingCart">
        @if(isset($cart['products']) && count($cart['products'])>0)
            <table style="width:100%;" class="table table-striped">
                @foreach($cart['products'] as $key=>$orderedProduct)
                    <tr id="{!! str_replace(' ','_',$orderedProduct['name']) !!}">
                        <td style="width:5%;">

                        </td>
                        <td style="width:70%;">
                            {{$orderedProduct['name']}}
                            <br />
                            <small>{!! $orderedProduct['description'] !!}</small>
                        </td>
                        <td style="width:25%;text-align:right;">
                            <strong>{{$orderedProduct['price']}} £</strong>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 p5" style="height:210px; !important;background: #fafafa;">
        <table style="width:100%;" class="table table-striped">
            <tr>
                <td style="width:75%;">
                    <strong>Subtotal</strong>
                    <br />
                    <small>Before delivery fees and taxes</small>
                </td>
                <td style="width:25%;text-align:right;" id="_subtotal">
                    <strong>
                        @if($cart!=null)
                            {{$cart['total']}}
                        @else
                            0.00
                        @endif £
                    </strong>
                </td>
            </tr>
            <tr>
                <td style="width:75%;">
                    <strong>Delivery Fee</strong>
                </td>
                <td style="width:25%;text-align:right;" id="_delivery">
                    <strong>
                        @if($cart!=null && isset($cart['service']['type']) && $cart['service']['type']=='delivery')
                            {{$cart['service']['price']}}
                        @else
                            0.00
                        @endif
                        £</strong>
                </td>
            </tr>
            <tr>
                <td style="font-size:12pt;"><strong>Discount</strong></td>
                <td style="font-size:12pt;" class="text-right">
                    @if($cart['cupon'] != null)
                        <strong>
                            -{{$cart['cupon']['price']}}
                            @if($cart['cupon']['type']=="Fixed") &pound; @else % @endif
                        </strong>
                    @else
                        <strong>0</strong>
                    @endif
                </td>

            </tr>
            <tr>
                <td style="width:75%;">
                    <strong>Total</strong>
                </td>
                <td style="width:25%;text-align:right;" id="_total">
                    <strong>

                        @php $total = 0; $service =0; $cupon = 0; @endphp
                        @if($cart!=null)
                        @if(isset($cart['service']['type']) && $cart['service']['type']=='delivery')
                        @php
                            $service = $cart['service']['price'];
                        @endphp
                        @endif
                        @if($cart!=null)
                            @php
                                $total = $cart['total'];
                            @endphp
                        @endif
                        @if($cart['cupon']!=null && $cart['cupon']['price']!=null)
                            @php
                                $cupon = $cart['cupon']['price'];
                            @endphp
                        @endif
                        @endif
                        {!!  number_format((($total + $service)-$cupon),2) !!}

                        £</strong>
                </td>
            </tr>
        </table>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
