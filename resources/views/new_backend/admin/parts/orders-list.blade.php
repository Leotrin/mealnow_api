<div class="card">
    <h6 class="card-header">Latest 15 Orders</h6>
    <div class="card-datatable table-responsive">
        <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer ">
            <div class="row">
                <div class="col-sm-12">
                    <table class="datatables-demo table table-striped table-bordered dataTable no-footer dataTableExample" id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info">
                        <thead>
                        <tr role="row">
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
                                <td class="text-center">{{$order->created_at}}</td>
                                <td class="text-center">{{$order->sum}} &pound;</td>
                                <td class="text-center">
                                    {!! CD::orderStatus($order->status) !!}
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('/admin/order/view/'.$order->id) }}" class="btn btn-info">
                                        <i class="fa fa-eye"></i>
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
</div>
