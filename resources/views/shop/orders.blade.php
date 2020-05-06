@extends('shop.index')

<style>
    .fiveminutes{
        border: 2px solid yellow;
    }
    .tenminutes{
        border: 2px solid red;
    }
</style>
@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>New <span class="semi-bold">Orders</span> (new & under adjustment)</h4>
                    <br/>
                    {{date('Y-m-d H:i')}}
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
                            <th>Contact</th>
                            <th>Order Data</th>
                            <th>Type</th>
                            <th>Ordered at</th>
                            <th>SUM</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(!empty($neworders))
                        @foreach($neworders as $item)
                            <tr class="odd gradeX">
                                <td>{{ $item->id }}</td>
                                {{--<td>{{ $item->shop->name }}</td>--}}
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
                                    <strong>{!! $item->user->name !!}</strong>
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
                                    {!! CD::orderStatusSPAN($item->status, $item->created_at) !!}
                                    <br/>
                                    {!! CD::processDate($item->status, $item->type, $item->date) !!}
                                </td>
                                <td>{{ $item->sum }}</td>
                                {{--<td class="center">{!! CD::orderStatus($item->status) !!}</td>--}}
                                <td class="center">
                                    <a href="{{ url('/shop/order/'.$item->id) }}" class="btn btn-info">
                                        <i class="fa fa-info"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="isForSearch"></th>
                            <th></th>
                            <th class="isForSearch"></th>
                            <th class="isForSearch"></th>
                            <th class="isForSearch"></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>To be processed (confirmed orders)</h4>
                    <br/>
                    {{date('Y-m-d H:i')}}
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
                            <th>user</th>
                            <th>Order Data</th>
                            <th>Type</th>
                            <th>Date/Time</th>
                            <th>SUM</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(!empty($confirmedorders))
                            @foreach($confirmedorders as $item)

                                <tr class="odd gradeX">
                                    <td>{{ $item->id }}</td>
                                    {{--<td>{{ $item->shop->name }}</td>--}}
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
                                        <strong>{!! $item->user->name !!}</strong>
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
                                        {!! CD::orderStatusSPAN($item->status, $item->date) !!}
                                        <br/>
                                        {!! CD::processDate($item->status, $item->type, $item->date) !!}
                                    </td>
                                    <td>{{ $item->sum }}</td>
                                    {{--<td class="center">{!! CD::orderStatus($item->status) !!}</td>--}}
                                    <td class="center">
                                        <a href="{{ url('/shop/order/'.$item->id) }}" class="btn btn-info">
                                            <i class="fa fa-info"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="isForSearch"></th>
                            <th></th>
                            <th class="isForSearch"></th>
                            <th class="isForSearch"></th>
                            <th class="isForSearch"></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        setTimeout(function () {
            location.reload();
        }, 60 * 1000);
    </script>
@endsection
