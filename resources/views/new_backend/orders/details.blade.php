@extends('layouts.new_admin')

@section('content')
    <div class="row-fluid" style="padding: 20px;">
        <div class="card">
            <div class="grid simple " style="padding:10px;">
                <div class="grid-title">
                    <h4>Order ID : <span class="semi-bold">{{$order->id}} {!! CD::orderStatus($order->status) !!}</span></h4>
                </div>
                <div class="grid-body ">
                    @if($order->assigned_user_id == auth()->user()->id && in_array($order->status, [0,3,4,6,8]))
                        <a class="btn btn-info" href="{{ url('admin/order/release/'.$order->id) }}">Release Order</a>
                    @elseif($order->assigned_user_id != null && $order->assigned_user_id>0)
                        <span class="btn btn-primary myTippy" data-toggle="modal" title="Phone Call Confirmation" data-target="#assigned_user_{{$order->id}}">
                            <i class="fa fa-user" aria-hidden="true"></i> Assigned User
                        </span>
                        <div class="modal fade" id="assigned_user_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Assigned User Data</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                        <table class="table table-striped">
                                            <tr>
                                                <td>ID:</td>
                                                <td>{{$order->assigned_user->id}}</td>
                                            </tr>
                                            <tr>
                                                <td>Name:</td>
                                                <td>{{$order->assigned_user->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Username:</td>
                                                <td>{{$order->assigned_user->username}}</td>
                                            </tr>
                                            <tr>
                                                <td>Email:</td>
                                                <td>{{$order->assigned_user->email}}</td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($order->status == 0)
                        <span class="btn btn-primary myTippy" data-toggle="modal" title="Phone Call Confirmation" data-target="#call_confirmation{{$order->id}}">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </span>
                        <div class="modal fade" id="call_confirmation{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Phone Call Confirmation</h4>
                                    </div>
                                    <div class="modal-body text-center">

                                        <a href="{{ url('/admin/order/call/'.$order->id) }}" @if($order->called>=1) disabled @endif class="btn btn-primary">Called 1</a>
                                        <a href="{{ url('/admin/order/call/'.$order->id) }}" @if($order->called>=2) disabled @endif class="btn btn-primary">Called 2</a>
                                        <a href="{{ url('/admin/order/call/'.$order->id) }}" @if($order->called==3) disabled @endif class="btn btn-primary">Called 3</a>
                                        <form action="{{ url('/admin/order/phone_confirmation/'.$order->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <label>PIN</label>
                                            <input type="number" patter=".{4}" name="pin" class="form-control" required />
                                            <hr />
                                            <button type="submit" name="submit" class="btn btn-success">Enter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <span class="btn btn-danger myTippy" data-toggle="modal" title="Reject Order" data-target="#reject_order_{{$order->id}}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
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
                                        <h6>You can't revert this again !</h6>
                                        <form action="{{url('admin/order/reject/'.$order->id)}}" method="post">
                                            {{csrf_field()}}
                                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">NO</button>
                                            <button type="submit" class="btn btn-danger">YES</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(in_array($order->status, [3,4,8]))
                        <span class="btn btn-default myTippy" data-toggle="modal" title="Complete Order" data-target="#complete_order_{{$order->id}}">
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
                                        <h6>This means that the client received the order and is satissfied.<br/><strong>You can't revert this again !</strong></h6>
                                        <form action="{{url('admin/order/complete/'.$order->id)}}" method="post">
                                            {{csrf_field()}}
                                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">NO</button>
                                            <button type="submit" class="btn btn-danger">YES</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <br/>
                    <div class="clearfix"></div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-6 p0">
                                <small>Created at {{$order->created_at}}</small>
                                <br />
                                Customer :
                                <span class="label" data-toggle="modal" title="Reject Order" data-target="#user_{{$order->id}}">
                        {{$order->user->name}} ({{$order->user->id}})
                    </span>
                                <div class="modal fade" id="user_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">User Data</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped">
                                                    <tr><td>Name:</td><td>{{$order->user->name}}</td></tr>
                                                    <tr><td>Username:</td><td>{{$order->user->username}}</td></tr>
                                                    <tr><td>Email:</td><td>{{$order->user->email}}</td></tr>
                                                    <tr><td>Tel:</td><td>{{$order->user->tel}}</td></tr>
                                                    <tr>
                                                        <td>Address:</td>
                                                        <td>{{$order->user->address}} {{$order->user->zip}} {{$order->user->city}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                <span class="label" data-toggle="modal" title="Phone Call Confirmation" data-target="#shop_{{$order->id}}">
                        {{ $order->shop->name }}
                    </span>
                                <div class="modal fade" id="shop_{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Shop Data</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped">
                                                    <tr><td>Name:</td><td>{{$order->shop->name}}</td></tr>
                                                    <tr><td>Address:</td><td>{{$order->shop->address}}</td></tr>
                                                    <tr><td>Tel:</td><td>{{$order->shop->tel}}</td></tr>
                                                    <tr><td>fax:</td><td>{{$order->shop->fax}}</td></tr>
                                                    <tr><td>Email:</td><td>{{$order->shop->email}}</td></tr>
                                                    @if($order->shop->isOpen)
                                                        <tr><td>is working?</td><td>YES, Till {{ $order->shop->openTill }}</td></tr>
                                                    @else
                                                        <tr><td>is working?</td>
                                                            @php $tmp = json_decode($order->shop->nextOpen, true);@endphp
                                                            <td>NO, Next open:{{$tmp['day']}} - At {{$tmp['start']}}</td>
                                                        </tr>
                                                    @endif

                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <div class="clearfix"></div>
                    <br />
                    <table class="table table-striped myTable" >
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Special</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php try{$products = json_decode($order->order);}catch(Exception $e){} ?>
                        @if($products)
                            @foreach($products as $product)
                                <tr>safasf
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
                                        <strong>{{$product->price}} &pound;</strong>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="col-md-8 p0">
                        @if(count($order->logs)>0)
                            <strong>Activity Log</strong>
                            <table class="table table-striped" >
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Activity</th>
                                    <th>Action</th>
                                    <th>Timestamp</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->logs as $log)
                                    <tr>
                                        <td><strong>{{$log->user->name}}</strong></td>
                                        <td>{{$log->value}}</td>
                                        <td><strong>{{$log->action}}</strong></td>
                                        <td><strong>{{$log->created_at}}</strong></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="col-md-12 text-right p0">
                        @if($order->delivery_price != 0)
                            <p>Delivery Fee  <strong>{{$order->delivery_price}} &pound;</strong></p>
                        @endif
                        @if($order->cupon_code != null)
                            <p>
                                Total without Cupon Code <strong>{{$order->sum_without_cupon}} &pound;</strong> <br />
                                User Cupon Code <strong> {{$order->cupon_code}}</strong> <br />
                                Discount <strong> - {{$order->discount}} &pound;</strong>
                            </p>
                        @endif
                        <h3>Total<strong> {{$order->sum}} &pound;</strong></h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

@endsection
