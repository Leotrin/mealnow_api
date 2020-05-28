
<form method="post" action="{{ url('/frontend/shops') }}" >
    {{csrf_field()}}
    <div class="col-md-4 col-xs-12 text-center" style="padding:5px 0 0 0;padding-bottom:-5px;">
        <div class="col-md-4 col-xs-4 p0 @if($service=='pickup') selectedServiceSearch @endif"  id="pickupSearchLabel" style="padding-top:7px;">
            Pickup
        </div>
        <div class="col-md-3 col-xs-3 p0">
            <label class="switch2">
                <input type="checkbox" name="pickup_delivery" value="delivery" id="searchPickupDelivery" onchange="changeServiceSelected()"
                       @if($service!='pickup')
                        checked
                       @endif
                >
                <span class="slider1 round"></span>
            </label>
        </div>
        <div class="col-md-4 col-xs-4 p0 @if($service=='delivery') selectedServiceSearch @endif" id="deliverySearchLabel"  style="padding-top:7px;padding-left:10px;">
            Delivery
        </div>
    </div>
    <div class="col-md-7 col-xs-10" style="padding:1px;">
        <input type="text" list="search_id" id="search_id_input"
               @if(isset($location)) value="{{$location}}" @endif
               name="location" placeholder="What is your location?" class="form-control borderRadiusCircle" />
            <datalist id="search_id">
                @foreach($cities as $city)
                    <option value="{{$city->search_city}}">
                @endforeach
            </datalist>
        </div>
    <div class="col-md-1 col-xs-2" style="padding:0px 0px 0px 10px;">
        <button type="submit" class="form-control btn btn-custom-color noBorder borderRadiusCircle" >
            <i class="fa fa-search"></i>
        </button>
    </div>
    <div class="clearfix"></div>
</form>