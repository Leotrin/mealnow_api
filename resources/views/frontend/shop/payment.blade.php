@extends('layouts.master')

@section('head')
    <meta name="publishable_key" content="{{config('stripe.publishable_key')}}" />
@endsection
@section('content')
<div class="top-links">
    <div class="container">
       <ul class="row links">
          <li class="col-xs-12 col-sm-3 link-item"><span>1</span><a href="/">Choose Your Location</a></li>
          <li class="col-xs-12 col-sm-3 link-item"><span>2</span><a href="/frontend/shops">Choose Restaurant</a></li>
          <li class="col-xs-12 col-sm-3 link-item "><span>3</span><a href="../">Pick Your favorite food</a></li>
          <li class="col-xs-12 col-sm-3 link-item active" style="padding:0 15px"><span>4</span><a href="#">Order and Pay online</a></li>
       </ul>
    </div>
 </div>
    <section  style="background: #fafafa;padding: 10% 0;">
        <div class="col-md-8 page-container p0" style="padding-bottom:40px;">
            <section style="padding:0px 0px;font-size:14px;">
                <div class="col-md-6">
                    <div class="col-md-12 p0">
                        <table class="table table-striped" style="width:100%;">

                            <?php $totali = $cart['total'] + $cart['service']['price']; ?>
                            @if($cart['cupon']==null)
                                <tr>
                                    <td colspan="2" style="border-top:none;text-align:center;">
                                        <form action="{{url('/frontend/shop/'.$shop->id.'/cupon')}}" method="post">
                                            <label>Enter Cupon Key</label>
                                            <input type="text" name="cupon_code" required placeholder="Cupon Key" class="form-control" />
                                            <br />
                                            <button type="submit" class="btn btn-info" style="width:100%">Submit cupon</button>
                                        </form>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td style="border-top:none;font-size:12pt;">Total without Cupon</td>
                                    <td style="border-top:none;font-size:12pt;" class="text-right">
                                        <strong>
                                            {{$totali}} $
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:12pt;">Cupon Key</td>
                                    <td style="font-size:12pt;" class="text-right">
                                        <strong>{{$cart['cupon']['key']}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:12pt;">Discount</td>
                                    <td style="font-size:12pt;" class="text-right">
                                        <strong>
                                            -{{$cart['cupon']['price']}}
                                            @if($cart['cupon']['type']=="Fixed") $ @else % @endif
                                        </strong>
                                    </td>
                                </tr>
                                <?php
                                    if($cart['cupon']['type']=="Fixed"){
                                        $totali = $totali - $cart['cupon']['price'];
                                    }else{
                                        $discount = ($totali/100)*$cart['cupon']['price'];
                                        $totali = $totali - $discount;
                                    }
                                ?>
                            @endif

                                <tr>
                                    <td style="font-size:12pt;">Total</td>
                                    <td style="font-size:12pt;" class="text-right">
                                        <strong>{{$totali}} $</strong>
                                    </td>
                                </tr>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-md-6 p0">
                        <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!! url("frontend/shop/$shop->id/checkout/payment")!!}" >
                            {{ csrf_field() }}
                            <div class='form-row'>
                                <div class='col-xs-12 form-group card required'>
                                    <label class='control-label'>Card Number</label>
                                    <input autocomplete='off' class='form-control card-number' size='20' type='text' name="card_no">
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='col-xs-4 form-group cvc required'>
                                    <label class='control-label'>CVV</label>
                                    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvvNumber">
                                </div>
                                <div class='col-xs-4 form-group expiration required'>
                                    <label class='control-label'>Expiration</label>
                                    <input class='form-control card-expiry-month' placeholder='MM' size='4' type='text' name="ccExpiryMonth">
                                </div>
                                <div class='col-xs-4 form-group expiration required'>
                                    <label class='control-label'> </label>
                                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="ccExpiryYear">
                                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='hidden' name="amount" value="300">
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='col-md-12' style="margin-left:-10px;">
                                    <div class='form-control total btn btn-primary' >
                                        Total:
                                        <span class='amount'>{!! $totali !!}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='col-md-12 form-group'>
                                    <button class='form-control btn btn-success submit-button' type='submit'>Pay »</button>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='col-md-12 error form-group hide'>
                                    <div class='alert-danger alert'>
                                        Please correct the errors and try again.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
{{--                    {{ Form::open(['class'=>'col-md-12 p0','id'=>'billing-form']) }}--}}
{{--                        <h3 class="text-center">Pay order now</h3>--}}
{{--                        <div class="form-row">--}}
{{--                            <label for="card-number">--}}
{{--                                Card Number:--}}
{{--                            </label>--}}
{{--                            <br />--}}
{{--                            <input type="text" id="cart-number" data-stripe="number" class="form-control"/>--}}
{{--                        </div>--}}
{{--                        <div class="form-row">--}}
{{--                            <label for="card-cvc">--}}
{{--                                CVC:--}}
{{--                            </label>--}}
{{--                            <br />--}}
{{--                            <input type="text" id="cart-cvc" data-stripe="cvc" class="form-control"/>--}}
{{--                        </div>--}}
{{--                        <div class="form-row">--}}
{{--                            <label for="card-expire">--}}
{{--                                Expiration Date:--}}
{{--                            </label>--}}
{{--                            <br />--}}
{{--                            <div class="col-md-6 p0">--}}
{{--                                {{ Form::selectMonth(null,null,['data-stripe'=>'exp-month','class'=>'form-control form-control-field-fix']) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 p0">--}}
{{--                                {{ Form::selectYear(null,date('Y'),date('Y')+10,null,['data-stripe'=>'exp-year','class'=>'form-control form-control-field-fix']) }}--}}
{{--                            </div>--}}
{{--                            <div class="clearfix"></div>--}}
{{--                        </div>--}}
{{--                        <br />--}}
{{--                        <div class="clearfix"></div>--}}
{{--                        <div class="col-md-12 p0 text-right">--}}
{{--                            {{Form::submit('Pay now',['class'=>'btn btn-primary'])}}--}}
{{--                        </div>--}}
{{--                    {{ Form::close() }}--}}
                    <div class="clearfix"></div>
                </div>
            </section>
        </div>
        <div class="col-md-3 page-container p0">
            @include('frontend.shop.cart.cartPreview')
        </div>
        <div class="clearfix"></div>
    </section>
@endsection

@section('footer')
    <script src="https://js.stripe.com/v1/"></script>

    <script>
        var baseUrl = '{{url('frontend/shop/'.$shop->id)}}';
    </script>
    <script src="{{asset('js/order.js')}}"></script>
    <script src="{{asset('js/billing.js')}}"></script>
@endsection
