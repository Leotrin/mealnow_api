@extends('customer.index')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Order <span class="semi-bold">management</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    @if($errors->any())
                        <p class="alert alert-danger">{{$errors->first()}}</p>
                    @endif
                    <table class="table table-striped" id="example" >
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Shop</th>
                            <th>Order Info</th>
                            <th>SUM</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $item)
                            <tr class="odd gradeX">
                                <td>{!! $item->id !!}</td>
                                <td>{!! $item->shop->name !!}
                                <td>
                                    @if($item->type == 'delivery')
                                        <i class="fa fa-truck" aria-hidden="true"></i> {!! ucfirst($item->type) !!} at
                                        <br/>
                                        <i class="fa fa-address-card-o" aria-hidden="true"></i> {!! $item->address !!}
                                        <br/>
                                        <i class="fa fa-calendar" aria-hidden="true"></i> {!! date('d-m-Y', strtotime($item->date)) !!}
                                        <i class="fa fa-clock-o" aria-hidden="true"></i> {!! date('H:i', strtotime($item->date)) !!}
                                    @else
                                        <i class="fa fa-users" aria-hidden="true"></i> {!! ucfirst($item->type) !!}
                                        <br/>
                                        {!! date('d-m-Y H:i', strtotime($item->date)) !!}
                                    @endif

                                </td>
                                <td>{!! $item->sum !!}</td>
                                <td class="center">{!! CD::orderStatus($item->status) !!}</td>
                                <td class="center">
                                    <a href="{{ url('/customer/order/'.$item->id) }}" class="btn btn-info">
                                        <i class="fa fa-info"></i>
                                    </a>
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