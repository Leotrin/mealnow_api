<div class="pb-2">
    <div class="bg-white rounded shadow-sm text-white mb-4 p-4 clearfix restaurant-detailed-earn-pts card-icon-overlap">
{{--        <h6 class="pt-0 text-primary mb-1 font-weight-bold">OFFER</h6>--}}
{{--        <p class="mb-0">60% off on orders above $99 | Use coupon <span class="text-danger font-weight-bold">OSAHAN50</span></p>--}}
{{--        <div class="icon-overlap">--}}
{{--            <i class="icofont-sale-discount"></i>--}}
{{--        </div>--}}
{{--        <hr>--}}
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
            <br /><span style="text-decoration: underline;color:#1e4d72;cursor: pointer;" data-toggle="modal" id="schedule_order_button" data-target="#scheduleOrder">Schedule</span>

        </div>
        <div class="btn-group btn-group-justified" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button type="button" class="changeToDelivery btn btn-default @if($schedule['service']=='delivery') btn-primary @endif btn-md" id="changeToDelivery" onclick="changeService('delivery')">Delivery</button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="changeToPickup btn btn-default @if($schedule['service']=='pickup') btn-primary @endif btn-md" id="changeToPickup"  onclick="changeService('pickup')">Pickup</button>
            </div>
        </div>
    </div>
</div>
<div class="generator-bg rounded shadow-sm mb-4 p-4 osahan-cart-item">
    <h5 class="mb-1 text-white">Your Order</h5>

    <div class="bg-white rounded shadow-sm mb-2" id="myShoppingCart">
        @if(isset($cart['products']) && count($cart['products'])>0)
            <table style="width:100%;" class="table table-striped">
                @foreach($cart['products'] as $key=>$orderedProduct)
                    <tr id="{!! str_replace(' ','_',$orderedProduct['name']) !!}">
                        <td style="width:5%;">
                            <span class="deleteIcon"><i onclick="deleteItemFromCart({{$key}})" class="fa fa-trash "></i></span>
                        </td>
                        <td style="width:70%;">
                            {{$orderedProduct['name']}}
                            <br />
                            <small>{!! $orderedProduct['description'] !!}</small>
                        </td>
                        <td style="width:25%;text-align:right;">
                            <strong>{{$orderedProduct['price']}} $</strong>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>

    <div class="mb-2 bg-white rounded p-2 clearfix">
        <h6 class="font-weight-bold text-right mb-2">
            Subtotal : <span class="text-danger"  id="_subtotal"> @if($cart!=null)
                    {{$cart['total']}}
                @else
                    0.00
                @endif $</span></h6>
        <p class="seven-color mb-1 text-right"><small>Before delivery fees and taxes</small></p>
        <p class="seven-color mb-1 text-right" >
            <strong>Delivery Fee : </strong>
            <strong id="_delivery">
                @if($cart!=null && isset($cart['service']['type']) && $cart['service']['type']=='delivery')
                    {{$cart['service']['price']}}
                @else
                    0.00
                @endif
                $</strong>
        </p>
        <p class="text-black mb-0 text-right" >
            <strong>Total : </strong>
            <strong id="_total">
                @if($cart!=null && isset($cart['service']['type']) && $cart['service']['type']=='delivery')
                    <?php
                    $total = $cart['total'] + $cart['service']['price'];
                    echo number_format($total,2);
                    ?>
                @elseif($cart!=null)
                    {{$cart['total']}}
                @else
                    0.00
                @endif

                $</strong>
        </p>
    </div>
    <input type="hidden" value="0" id="nothing" />
    <button type="button" class="btn btn-success" onclick="continueToCheckout()" style="width:100%;font-weight: bold;">Continue to checkout <i class="icofont-long-arrow-right"></i></button>
</div>
