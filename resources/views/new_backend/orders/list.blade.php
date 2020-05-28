@extends('layouts.new_admin')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Orders</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item" >Orders</li>
            </ol>
        </div>
        @if(auth()->user()->group_id != 1)
            <div class="card">
                <h6 class="card-header">My Orders List</h6>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table class="table table-striped myTable" id="DataTables_Table_1" role="grid" >
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Shop</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Type</th>
                                <th>Date/Time</th>
                                <th>SUM</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($myorders as $item)
                                <tr class="odd gradeX">
                                    <td>{{ $item->id }}</td>
                                    <td>
                                     <span class="btn btn-primary myTippy" data-toggle="modal" title="Phone Call Confirmation" data-target="#shop_{{$item->id}}">
                                        {{ $item->shop->name }}
                                    </span>
                                        <div class="modal fade" id="shop_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Shop Data</h4>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <table>
                                                            <tr>
                                                                <td>Name</td>
                                                                <td>{{$item->shop->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Address</td>
                                                                <td>{{$item->shop->address}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tel:</td>
                                                                <td>{{$item->shop->tel}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>fax:</td>
                                                                <td>{{$item->shop->fax}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Email:</td>
                                                                <td>{{$item->shop->email}}</td>
                                                            </tr>
                                                            @if($item->shop->isOpen)
                                                                <tr>
                                                                    <td>is working?</td>
                                                                    <td>YES, Till {{ $item->shop->openTill }}</td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td>is working?</td>
                                                                    @php $tmp = json_decode($order->shop->nextOpen, true);@endphp
                                                                    <td>@if(isset($tmp['day'])) NO, Next open:{{$tmp['day']}} - At {{$tmp['start']}} @endif</td>
                                                                </tr>
                                                            @endif

                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td style="text-transform: capitalize;">
                                        @if(count($item->shop->contact_methods)>0)
                                            @if($item->shop->contact_methods[0]->method=='email' || $item->shop->contact_methods[0]->method=='sms' )
                                                <i class="fa fa-check"></i>
                                            @else
                                                <i class="fa fa-times"></i>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->scheduled)
                                            Scheduled {!! ucfirst($item->type) !!}
                                        @else
                                            {!! ucfirst($item->type) !!}
                                        @endif
                                        <br/>
                                        <strong>{!! $item->user->name !!}</strong> ({!! $item->user->id !!})
                                        <br />
                                        <strong>{{ $item->address }}</strong>
                                        <br/>
                                        <i class="fa fa-calendar"></i>{!! date('d-m-Y', strtotime($item->date)) !!}
                                        <i class="fa fa-clock"></i>{!! date('H:i', strtotime($item->date)) !!}
                                    </td>
                                    <td>
                                        @if($item->scheduled)
                                            Scheduled {!! ucfirst($item->type) !!}
                                        @else
                                            {!! ucfirst($item->type) !!}
                                        @endif
                                    </td>
                                    <td>
                                        {!! CD::orderStatusAdminSPAN($item->status, $item->created_at) !!}
                                        <br/>
                                        <?php $datedif = date_diff(date_create(date('Y-m-d H:i:s')), date_create($item->date)) ;?>
                                        <p>Untill order time:<br/> {{ $datedif->d  }}d {{ $datedif->h }}h {{ $datedif->i }}m</p>


                                    </td>
                                    <td>{{ $item->sum }}</td>
                                    <td class="center">
                                        <a href="{{ url('/admin/order/view/'.$item->id) }}" class="btn btn-info">
                                            <i class="fa fa-info"></i>
                                        </a>
                                        @if($item->status == 3 || $item->status == 4)
                                            <a href="{{ url('admin/order/complete/'.$item->id) }}" class="btn btn-secondary">
                                                Complete
                                            </a>
                                        @endif

                                        {{--@if($item->status == 0)--}}
                                        {{--<span class="btn btn-primary myTippy" data-toggle="modal" title="Phone Call Confirmation" data-target="#call_confirmation{{$item->id}}">--}}
                                        {{--<i class="fa fa-phone" aria-hidden="true"></i>--}}
                                        {{--</span>--}}
                                        {{--<div class="modal fade" id="call_confirmation{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
                                        {{--<div class="modal-dialog" role="document">--}}
                                        {{--<div class="modal-content">--}}
                                        {{--<div class="modal-header">--}}
                                        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                                        {{--<h4 class="modal-title" id="myModalLabel">Phone Call Confirmation</h4>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-body text-center">--}}
                                        {{--<a href="{{ url('/admin/order/call/'.$item->id) }}" @if($item->called>=1) disabled @endif class="btn btn-primary">Called 1</a>--}}
                                        {{--<a href="{{ url('/admin/order/call/'.$item->id) }}" @if($item->called>=2) disabled @endif class="btn btn-primary">Called 2</a>--}}
                                        {{--<a href="{{ url('/admin/order/call/'.$item->id) }}" @if($item->called==3) disabled @endif class="btn btn-primary">Called 3</a>--}}
                                        {{--<form action="{{ url('/admin/order/phone_confirmation/'.$item->id) }}" method="post">--}}
                                        {{--{{ csrf_field() }}--}}
                                        {{--<label>PIN</label>--}}
                                        {{--<input type="number" patter=".{4}" name="pin" class="form-control" required />--}}
                                        {{--<hr />--}}
                                        {{--<button type="submit" name="submit" class="btn btn-success">Enter</button>--}}
                                        {{--</form>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<span class="btn btn-danger myTippy" data-toggle="modal" title="Reject Order" data-target="#reject_order_{{$item->id}}">--}}
                                        {{--<i class="fa fa-trash" aria-hidden="true"></i>--}}
                                        {{--</span>--}}
                                        {{--<div class="modal fade" id="reject_order_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
                                        {{--<div class="modal-dialog" role="document">--}}
                                        {{--<div class="modal-content">--}}
                                        {{--<div class="modal-header">--}}
                                        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                                        {{--<h4 class="modal-title" id="myModalLabel">Reject Order</h4>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-body text-center">--}}
                                        {{--<h3>Are you sure ?</h3>--}}
                                        {{--<h6>You can't revert this again !</h6>--}}
                                        {{--<form action="{{url('admin/orders/reject/'.$item->id)}}" method="post">--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">NO</button>--}}
                                        {{--<button type="submit" class="btn btn-danger">YES</button>--}}

                                        {{--</form>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--@endif--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <br/>
        <div class="card">
            <h6 class="card-header">New Orders List</h6>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <table class="table table-striped myTable" id="DataTables_Table_1" role="grid" >
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Shop</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Type</th>
                            <th>Date/Time</th>
                            <th>SUM</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($neworders as $item)
                            <tr class="odd gradeX">
                                <td>{{ $item->id }}</td>
                                <td>
                                    <span class="btn btn-primary myTippy" data-toggle="modal" title="Phone Call Confirmation" data-target="#shop_{{$item->id}}">
                                        {{ $item->shop->name }}
                                    </span>
                                    <div class="modal fade" id="shop_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Phone Call Confirmation</h4>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <table>
                                                        <tr>
                                                            <td>Name</td>
                                                            <td>{{$item->shop->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address</td>
                                                            <td>{{$item->shop->address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tel:</td>
                                                            <td>{{$item->shop->tel}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>fax:</td>
                                                            <td>{{$item->shop->fax}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email:</td>
                                                            <td>{{$item->shop->email}}</td>
                                                        </tr>
                                                        @if($item->shop->isOpen)
                                                            <tr>
                                                                <td>is working?</td>
                                                                <td>YES, Till {{ $item->shop->openTill }}</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td>is working?</td>
                                                                <td>@if(isset($item->shop->nextOpen['day'])) NO, {{$item->shop->nextOpen['day']}} - At {{$item->shop->nextOpen['start']}} @endif</td>
                                                            </tr>
                                                        @endif

                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td style="text-transform: capitalize;">
                                    @if(count($item->shop->contact_methods)>0)
                                        @if($item->shop->contact_methods[0]->method=='email' || $item->shop->contact_methods[0]->method=='sms' )
                                            <i class="fa fa-check"></i>
                                        @else
                                            <i class="fa fa-times"></i>
                                        @endif
                                    @endif
                                </td>

                                <td>
                                    @if($item->scheduled)
                                        Scheduled {!! ucfirst($item->type) !!}
                                    @else
                                        {!! ucfirst($item->type) !!}
                                    @endif
                                    <br/>
                                    <strong>{!! $item->user->name !!}</strong> ({!! $item->user->id !!})
                                    <br />
                                    <strong>{{ $item->address }}</strong>
                                    <br/>
                                    <i class="fa fa-calendar"></i>{!! date('d-m-Y', strtotime($item->date)) !!}
                                    <i class="fa fa-clock"></i>{!! date('H:i', strtotime($item->date)) !!}
                                </td>
                                <td>
                                    @if($item->scheduled)
                                        Scheduled {!! ucfirst($item->type) !!}
                                    @else
                                        {!! ucfirst($item->type) !!}
                                    @endif
                                </td>
                                <td>
                                    {!! CD::orderStatusAdminSPAN($item->status, $item->created_at) !!}
                                    <br/>
                                    @if(in_array($item->status, [0,3,4,8,6]))
                                        <?php $datedif = date_diff(date_create(date('Y-m-d H:i:s')), date_create($item->date)) ;?>
                                        {{ $datedif->d  }}d {{ $datedif->h }}h {{ $datedif->i }}m
                                    @else{!! CD::orderStatus($item->status) !!}

                                    @endif
                                </td>
                                <td>{{ $item->sum }}</td>
                                <td class="center">
                                    <a href="{{ url('/admin/order/view/'.$item->id) }}" class="btn btn-info">
                                        <i class="fa fa-info"></i>
                                    </a>

                                    {{--@if($item->status == 0)--}}
                                    {{--<span class="btn btn-primary myTippy" data-toggle="modal" title="Phone Call Confirmation" data-target="#call_confirmation{{$item->id}}">--}}
                                    {{--<i class="fa fa-phone" aria-hidden="true"></i>--}}
                                    {{--</span>--}}
                                    {{--<div class="modal fade" id="call_confirmation{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
                                    {{--<div class="modal-dialog" role="document">--}}
                                    {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                                    {{--<h4 class="modal-title" id="myModalLabel">Phone Call Confirmation</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-body text-center">--}}

                                    {{--<a onclick="called('{{ url('/admin/orders/called/'.$item->id) }}',1)" @if($item->called>=1) disabled @endif id='called1' class="btn btn-primary">Called 1</a>--}}
                                    {{--<a onclick="called('{{ url('/admin/orders/called/'.$item->id) }}',2)" @if($item->called>=2) disabled @endif id='called2' class="btn btn-primary">Called 2</a>--}}
                                    {{--<a onclick="called('{{ url('/admin/orders/called/'.$item->id) }}',3)" @if($item->called==3) disabled @endif id='called3' class="btn btn-primary">Called 3</a>--}}
                                    {{--<form action="{{ url('/admin/orders/phone_confirmation/'.$item->id) }}" method="post">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--<label>PIN</label>--}}
                                    {{--<input type="number" patter=".{4}" name="pin" class="form-control" required />--}}
                                    {{--<hr />--}}
                                    {{--<button type="submit" name="submit" class="btn btn-success">Enter</button>--}}
                                    {{--</form>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}

                                    {{--<span class="btn btn-danger myTippy" data-toggle="modal" title="Reject Order" data-target="#reject_order_{{$item->id}}">--}}
                                    {{--<i class="fa fa-trash" aria-hidden="true"></i>--}}
                                    {{--</span>--}}
                                    {{--<div class="modal fade" id="reject_order_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
                                    {{--<div class="modal-dialog" role="document">--}}
                                    {{--<div class="modal-content">--}}
                                    {{--<div class="modal-header">--}}
                                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                                    {{--<h4 class="modal-title" id="myModalLabel">Reject Order</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="modal-body text-center">--}}
                                    {{--<h3>Are you sure ?</h3>--}}
                                    {{--<h6>You can't revert this again !</h6>--}}
                                    {{--<form action="{{url('admin/orders/reject/'.$item->id)}}" method="post">--}}
                                    {{--{{csrf_field()}}--}}
                                    {{--<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">NO</button>--}}
                                    {{--<button type="submit" class="btn btn-danger">YES</button>--}}

                                    {{--</form>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--@endif--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

