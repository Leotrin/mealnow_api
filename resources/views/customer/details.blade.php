@extends('customer.index')

@section('head')
    <meta name="publishable_key" content="{{Config::get('stripe.publishable_key')}}" />
@endsection

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Order ID : <span class="semi-bold">{{$order->id}} {!! CD::orderStatus($order->status) !!}</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    @if($order->status == 0 )
                        <span class="btn btn-danger myTippy" data-toggle="modal" title="Reject Order" data-target="#reject_order_{{$order->id}}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </span>
                        <div class="modal fade" id="reject_order_{!! $order->id !!}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Reject Order</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h3>Are you sure ?</h3>
                                        <h6>You can't revert this again !</h6>
                                        <form action="{{url('customer/order/reject/'.$order->id)}}" method="post">
                                            {{csrf_field()}}
                                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">NO</button>
                                            <button type="submit" class="btn btn-danger">YES</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(new DateTime() > new DateTime($order->date) && in_array($order->status, [3,4,8]) )

                        <a href="{{ url('/customer/order/complete/'.$order->id) }}" class="btn btn-info">
                            Order Completed
                        </a>
                    @else
                        <span class="label">Order will be available for completetion after scheduletd time</span>
                    @endif
                    @if($order->status == 6 && $order->has_adjustment)
                            <span class="btn btn-success myTippy" data-toggle="modal" title="Shop requested adjustment on this Order" data-target="#adjust_order_{{$order->id}}">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Shop Adjustment details.
                            </span>
                            <div class="modal fade" id="adjust_order_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Adjust Order</h4>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h3>Order Adjustment status ?</h3>
                                            <form action="{{url('customer/order/adjust/'.$order->id)}}" method="post" id="billing-form" class="col-md-12" >
                                                {{csrf_field()}}
                                                <h3 class="text-center">Pay order now</h3>
                                                <div class="form-row">
                                                    <label for="card-number">
                                                        Card Number:
                                                    </label>
                                                    <br />
                                                    <input type="text" id="cart-number" data-stripe="number" class="form-control"/>
                                                </div>
                                                <div class="form-row">
                                                    <label for="card-cvc">
                                                        CVC:
                                                    </label>
                                                    <br />
                                                    <input type="text" id="cart-cvc" data-stripe="cvc" class="form-control"/>
                                                </div>
                                                <div class="form-row">
                                                    <label for="card-expire">
                                                        Expiration Date:
                                                    </label>
                                                    <br />
                                                    <div class="col-md-6 p0">
                                                        {{ Form::selectMonth(null,null,['data-stripe'=>'exp-month','class'=>'form-control']) }}
                                                    </div>
                                                    <div class="col-md-6 p0">
                                                        {{ Form::selectYear(null,date('Y'),date('Y')+10,null,['data-stripe'=>'exp-year','class'=>'form-control']) }}
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <br />
                                                <div class="clearfix"></div>
                                                <div class="col-md-12 p0 text-right">
                                                    {{Form::submit('Pay now',['class'=>'btn btn-primary'])}}
                                                </div>
                                            </form>
                                            <div class="clearfix"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif
                        <br /><br />
                        <div class="clearfix"></div>
                    <div class="col-md-6 p0">
                        Customer : <strong>{{$order->user->name}}</strong>
                        <br />
                        <small>Created at {{date('Y-m-d H:i', strtotime($order->created_at))}}</small>
                        <br />
                        <strong>{!! ucfirst($order->type) !!}</strong>
                        <br />
                        <strong>
                        @if($order->address)
                            {!! $order->address !!}
                        @else
                            {{$order->user->address}}
                        @endif
                        </strong>
                        <br/>
                        <i class="fa fa-calendar" aria-hidden="true"></i> {{ date('d M Y', strtotime($order->date)) }}
                        <i class="fa fa-clock-o" aria-hidden="true"></i> {!! date('H:i', strtotime($order->date)) !!}
                    </div>
                    <div class="col-md-6 p0 text-right">
                        <img src="{{asset('images/shops/'.$order->shop_id.'/'.$order->shop->logo)}}" style="width:100px;" />
                        <br />
                        <strong>{{$order->shop->name}}</strong>
                    </div>
                    <div class="clearfix"></div>
                    <br />
                    <table class="table table-striped dataTableSort" >
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Special</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $products = json_decode($order->order); ?>
                        @if(count($products)>0)
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        <strong>{{$product->name}}</strong><br />
                                        <small>{!! $product->description !!}</small>
                                    </td>
                                    <td>
                                        @if($product->special == true)
                                            <span class="label label-success">YES</span>
                                        @else
                                            <span class="label label-danger">NO</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$product->price}} &pound;
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="col-md-6 p0">
                        {{--@if(count($order->logs)>0)--}}
                            {{--<strong>Activity Log</strong>--}}
                            {{--<table class="table table-striped" style="width:100%;">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Action</th>--}}
                                    {{--<th>Timestamp</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--@foreach($order->logs as $log)--}}
                                    {{--<tr>--}}
                                        {{--<td>--}}
                                            {{--<strong>{{$log->action}}</strong>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<strong>{{$log->created_at}}</strong>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--@endif--}}
                    </div>
                    <div class="col-md-6 text-right p0">
                        @if($order->delivery_price != 0)
                            <p>
                                Delivery Fee  <strong>{{$order->delivery_price}} &pound;</strong>
                            </p>
                        @endif
                        @if($order->cupon_code != null)
                            <p>
                                Total without Cupon Code <strong>{{$order->sum_without_cupon}} &pound;</strong> <br />
                                User Cupon Code <strong> {{$order->cupon_code}}</strong> <br />
                                Discount <strong> - {{$order->discount}} &pound;</strong>
                            </p>
                        @endif
                        <h3>
                            Total<strong> {{$order->sum}} &pound;</strong>
                        </h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="https://js.stripe.com/v1/"></script>
    <script src="{{asset('js/billing.js')}}"></script>
    @endsection
