@extends('shop.index')

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
                    @if($order->status ==0)
                        <span class="btn btn-primary myTippy" data-toggle="modal" title="Confirm your order using the PIN number" data-target="#call_confirmation{{$order->id}}">
                            Confirm
                        </span>
                        <div class="modal fade" id="call_confirmation{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                        <form action="{{ url('/shop/order/confirmation/'.$order->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <label>PIN</label>
                                            <input type="number" patter=".{4}" name="pin" class="form-control" required />
                                            <hr />
                                            <button type="submit" name="submit" class="btn btn-success">Confirm</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="btn btn-danger myTippy" data-toggle="modal" title="Reject Order" data-target="#reject_order_{{$order->id}}">
                            Reject
                        </span>
                        <div class="modal fade" id="reject_order_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Reject Order</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h3>Are you sure ?</h3>
                                        <h6>You can't revert this action !</h6>
                                        <form action="{{url('shop/order/reject/'.$order->id)}}" method="post">
                                            {{csrf_field()}}
                                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">NO</button>
                                            <button type="submit" class="btn btn-danger">YES</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <span class="btn btn-dark myTippy" data-toggle="modal" title="Request order adjust" data-target="#adjust_order_{{$order->id}}">
                            Adjustment request
                        </span>
                        <div class="modal fade" id="adjust_order_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Request Order Adjustment</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                        <form action="{{ url('/shop/order/adjust/'.$order->id) }}" method="post">
                                            {{ csrf_field() }}

                                            <label>Describe adjustment?</label>
                                            <textarea name="adjust" class="form-control" placeholder="Description" required></textarea>

                                            <label>Amount</label>
                                            <input type="number" min="1" max="999" name="amount" class="form-control" required />

                                            <hr />
                                            <button type="submit" name="submit" class="btn btn-success">Confirm</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($order->status == 3 || $order->status == 4 || $order->status == 8)
                        @php
                            $d1 = new \DateTime(date('Y-m-d H:i'));
                            $d2 = new \DateTime(date('Y-m-d H:i', strtotime($order->date)));
                            $diff = $d1->diff($d2);
                        @endphp
                        @if((int)$diff->format("%r%d") <= 0 && ((int)$diff->format("%r%h") < 0 || (int)$diff->format("%r%i") < 0))
                        <span class="btn btn-primary myTippy" data-toggle="modal" title="Complete Order" data-target="#complete_order_{{$order->id}}">
                            Complete
                        </span>
                        <div class="modal fade" id="complete_order_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Complete Order</h4>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h3>Are you sure ?</h3>
                                            <h6>The client should have received the order before completion.</h6>
                                            <form action="{{url('shop/order/complete/'.$order->id)}}" method="post">
                                                {{csrf_field()}}
                                                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">NO</button>
                                                <button type="submit" class="btn btn-primary">YES</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if($order->status == 6)
                        Order Under Adjustment. Waiting client response
                    @endif
                    <br/><br/>
                    <div class="clearfix"></div>
                    <div class="col-md-6 p0">
                        <small>Created at {{$order->created_at}}</small>
                        <br />
                        Customer : <strong>{{$order->user->name}}</strong>
                        <br />

                        @if($order->type == 'pickup' && !$order->scheduled)
                            <strong>Pickup (ASAP)</strong>

                        @elseif($order->type == 'pickup' && $order->scheduled)
                            <strong>Pickup</strong> on
                        @elseif($order->type == 'delivery' && !$order->scheduled)
                            <strong>DELIVERY</strong> (ASAP) {{$order->created_at}}
                            <i class="fa fa-home"></i><strong>{{$order->address}}</strong>
                        @elseif($order->type == 'delivery' && $order->scheduled)
                            <strong>Scheduled DELIVERY</strong>
                            <br/>
                            <i class="fa fa-home"></i> <strong>{{$order->address}}</strong>
                        @endif
                        <br/>
                        <i class="fa fa-calendar"></i> {!! date('d-m-Y', strtotime($order->date)) !!}
                        <i class="fa fa-clock-o"></i>{!! date('H:i', strtotime($order->date)) !!}
                        <br />
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
                                        {{$product->price}} $
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="col-md-6 p0">
                        @if(count($order->logs)>0)
                            <strong>Activity Log</strong>
                            <table class="table table-striped" style="width:100%;">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Timestamp</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->logs as $log)
                                    @if(stristr($log->action, 'sms')
                                    || stristr($log->action, 'email')
                                    || stristr($log->action, 'call')
                                    || stristr($log->action, 'adjust')
                                    || stristr($log->action, 'create')
                                    || stristr($log->action, 'confirm')
                                    || stristr($log->action, 'complete'))
                                    <tr>
                                        <td>
                                            <strong>{{$log->action}}</strong>
                                        </td>
                                        <td>
                                            <strong>{{$log->created_at}}</strong>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="col-md-6 text-right p0">
                        @if($order->delivery_price != 0)
                            <p>
                                Delivery Fee:  <strong>{{$order->delivery_price}} $</strong>
                            </p>
                        @endif
                        @if($order->cupon_code != null)
                            <p>
                                Total without Cupon Code <strong>{{$order->sum_without_cupon}} $</strong> <br />
                                User Cupon Code <strong> {{$order->cupon_code}}</strong> <br />
                                Discount: <strong> - {{$order->discount}} $</strong>
                            </p>
                        @endif
                        @if($order->has_adjustment)

                            <h4>Subtotal<strong> {{$order->sum}} $</strong> </h4>
                                <p>Aditional Adjustment: {{$order->adjustment->amount}} $</p>
                            <h3>
                                Total<strong> {{$order->sum + $order->adjustment->amount}} $</strong>
                            </h3>
                        @else
                        <h3>
                            Total<strong> {{$order->sum}} $</strong>
                        </h3>
                        @endif
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
