<div class="col-md-12 p0">
    <div class="span12">
        <div class="grid simple">
            <div class="grid-title" style="padding:10px 10px 0 10px">
                <h4 style="color:#296eb6;">Leates <span class="semi-bold">15</span> Orders</h4>
                <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                </div>
            </div>
            <div class="grid-body">
                <table class="table table-bordered no-more-tables dataTableExample">
                    <thead>
                        <tr>
                            <th style="width:1%">ID</th>
                            <th class="text-center">Shop</th>
                            <th class="text-center">Date & Time</th>
                            <th class="text-center">Sum</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($latestOrders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td class="text-center">{{$order->shop->name}}</td>
                            <td class="text-right">{{$order->created_at}}</td>
                            <td class="text-center">{{$order->sum}} $</td>
                            <td class="text-center">
                                {!! CD::orderStatus($order->status) !!}
                            </td>
                            <td class="text-center">
                                <a href="{{ url('/admin/orders/view/'.$order->id) }}" class="btn btn-info">
                                    <i class="fa fa-search"></i>
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
