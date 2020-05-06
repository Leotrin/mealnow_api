@if(!$shop->isOpen)
<div class="modal fade" id="closedShop" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-danger" id="myModalLabel">Currently Closed</h4>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('images/store.png')}}" style="margin:auto;width:64px;" />
                <br />
                <div class="col-md-8 text-center col-md-offset-2">
                    <h4>
                        <strong>
                            This Restaurant is Currently Not Accepting Online Orders
                        </strong>
                    </h4>
                    <h6>{{$shop->name}}</h6>
                    @if(isset($shop->nextOpen['day']))
                    <h6>Next Open:  @if(date('d-m-Y') == $shop->nextOpen['day'])
                                        Today
                                    @else
                                        {{date('l', strtotime($shop->nextOpen['day']))}}
                                    @endif
                        at {{$shop->nextOpen['start']}}</h6>
                    @endif
                    <br />
                    <div class="col-md-8 col-md-offset-2">
                        <button class="btn btn-danger" style="width:100%;" data-dismiss="modal" onclick="shop_is_closed()">Schedule an Order</button>
                        <br />
                        <br />
                        <a href="{{ url()->previous() }}" class="btn btn-danger-dark" style="border:1px solid #9c251e;border-radius: 5px;width:100%;">Search for other Restaurants</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endif