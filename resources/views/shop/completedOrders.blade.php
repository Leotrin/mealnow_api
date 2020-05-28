@extends('shop.index')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Order <span class="semi-bold">management</span> (completed, rejected, unprocessed)</h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    @if($errors->any())
                        <p class="alert alert-danger">{{$errors->first()}}</p>
                    @endif
                        <table class="table table-striped dataTableSort" id="dataTableSort" >
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            {{--<th>Shop</th>--}}
                            <th>Contact</th>
                            <th>Client</th>
                            <th>Address</th>
                            <th>Type</th>
                            <th>Date/Time</th>
                            <th>SUM</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($orders))
                        @foreach($orders as $item)
                            <tr class="odd gradeX">
                                <td>{{ $item->id }}</td>
                                {{--<td>{{ $item->shop->name }}</td>--}}
                                <td style="text-transform: capitalize;">
                                    @if(count($item->shop->contact_methods)>0)
                                        @if($item->shop->contact_methods[0]->method=='email' || $item->shop->contact_methods[0]->method=='sms' )
                                            <i class="fa fa-check"></i>
                                        @endif
                                    @endif

                                </td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    @if($item->scheduled)
                                        Scheduled {{ ucfirst($item->type) }}
                                    @else
                                        {{ ucfirst($item->type) }}
                                    @endif
                                </td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->sum }}</td>
                                <td class="center">{!! CD::orderStatus($item->status) !!}</td>
                                <td class="center">
                                    <a href="{{ url('/shop/order/'.$item->id) }}" class="btn btn-info">
                                        <i class="fa fa-info"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
