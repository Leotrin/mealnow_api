<script>
    var workingDays = '<?php echo $shop->working_hours; ?>';
    //initializeScheduleCalendar(workingDays, disabledDays);
    var valid_address = null;
    lat = null;
    lng = null;
</script>
<div class="modal fade" id="scheduleOrder" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Order Date & Time</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body text-center">
                <div class="col-md-12">
                    <div class="btn-group btn-group-justified" role="group" style="margin-bottom:10px;">
                        <div class="btn-group" role="group">
                                <button type="button" class="changeToDelivery btn btn-default @if($schedule['service']=='delivery') btn-primary @endif btn-md" id="changeToDelivery" onclick="changeService('delivery')">Delivery</button>
                        </div>
                        <div class="btn-group" role="group">
                                <button type="button" class="changeToPickup btn btn-default @if($schedule['service']=='pickup') btn-primary @endif btn-md" id="changeToPickup"  onclick="changeService('pickup')">Pickup</button>
                        </div>
                    </div>
                    <hr>
                When would you like your order?
                <br/>

                <div class="btn-group btn-group-justified" role="group" style="margin-top:10px;">
                    <div class="btn-group" role="group">
                            <button type="button" class="changeToNow btn btn-default @if($schedule['time']=='now') btn-primary @endif btn-md" id="changeToNow" onclick="changeTime('now')" @if(!$shop->isOpen) disabled @endif>Now</button>
                    </div>
                    <div class="btn-group" role="group">
                            <button type="button" class="changeToLater btn btn-default @if($schedule['time']=='later') btn-primary @endif btn-md" id="changeToLater"  onclick="changeTime('later')">Later</button>
                    </div>
                </div>

                    <div id="scheduleDateTime" class="scheduleDateTime row" style="@if($schedule['time']=='now')display:none; @endif" >
                        <h5 style="margin:5px auto;">If you want to schedule an order <br/>please select date and time.</h5>
                        <div class="col-md-6 text-left" style="padding-top: 0; padding-bottom:0%">
                            <span><i class="fa fa-calendar-o"></i> Date</span>
                            <br />
                            <select name="schedule_date" id="schedule_date" class="form-control form-control-field-fix" onchange="getWorkingHours(workingDays)" >
                                    <option value="">Select a date</option>
                                @foreach($shop->workingDays as $day)
                                    <option value="{{$day}}">{{date('D, M jS Y', strtotime($day))}}</option>
                                    @endforeach
                            </select>
                            {{--<input type="text" name="schedule_date" placeholder="Select Schedule Date" id="schedule_date" class="form-control" />--}}
                        </div>
                        <div class="col-md-6 text-left">
                            <span><i class="fa fa-clock-o"></i> Time</span>
                            <br />
                            <input type="text" name="schedule_time" placeholder="Select Time in 24h format" value="" id="schedule_time" class="form-control"  />
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr />
                    <div class="col-md-12 p0 deliveryAddressModal" style="@if($schedule['service']=='pickup') display:none; @endif">
                        <h5>
                            Delivery address.
                        </h5>
                        <style>
                            .pac-container {
                                z-index: 1051 !important;
                            }
                        </style>
                        <div class="col-md-12 p5 text-left" style="padding-top: 0;">
                            <span><i class="fa fa-user"></i> Name</span>
                            <br />
                            <input type="text" name="name_input" placeholder="Enter name" id="name_input" class="form-control"
                                   @if(\Illuminate\Support\Facades\Auth::check())
                                   value="{{auth()->user()->name}}"
                                   @endif
                                   required />
                        </div>
                        <div class="col-md-12 p5 text-left" style="padding-top: 0;">
                            <span><i class="fa fa-map-marker"></i> Address</span>
                            <br />
                            <input type="text" name="address_input" placeholder="Enter Address" id="address_input" class="form-control"
                                   @if(auth()->check()) value="{{ auth()->user()->address.', '.auth()->user()->zip.' '.auth()->user()->city }}" @endif
                                   onFocus="geolocate()" />
                </div>
                <div class="clearfix"></div>
                        <hr />
                    </div>
                    <div class="clearfix"></div>
                        <div class="row p0 text-center">
                            <div class="col-md-6 ">
                                <button class="btn btn-primary" data-dismiss="modal" style="width:100%;">Cancel</button>
                            </div>
                            <div class="col-md-6 ">
                                <button class="btn btn-success" style="width:100%;" onClick="changeOrder(valid_address, lat, lng, '{{$shop->lat_long}}')">Save</button>
                </div>
                <div class="clearfix"></div>
            </div>
                    <div class="clearfix"></div>
        </div>
                <div class="clearfix"></div>
    </div>
</div>
    </div>
</div>

<script>
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('address_input')),
            {types: ['geocode'], componentRestrictions: {country: "uk"}});
        autocomplete.addListener('place_changed', fillInAddress);
    }
    function fillInAddress() {
        var place = autocomplete.getPlace();
        console.log(place);
        if(place != null && place.address_components != null && place.address_components.length >0 ){
//                        for (var i = 0; i < place.address_components.length; i++) {
//                            var addressType = place.address_components[i].types[0];
//                            if (componentForm[addressType]) {
//                                var val = place.address_components[i][componentForm[addressType]];
//                            }
//                        }
            console.log(place);
            console.log(place.geometry.location.lat());
            console.log(place.geometry.location.lng());
            lat = place.geometry.location.lat();
            lng = place.geometry.location.lng();

            var shop_lat_lng = new google.maps.LatLng(<?php echo $shop->lat_long;?>);
            var client_lat_lng = new google.maps.LatLng(lat,lng);
            var distance = google.maps.geometry.spherical.computeDistanceBetween (shop_lat_lng, client_lat_lng);
            console.log(distance);

            valid_address = true;
        }else{
            valid_address =  false;
        }
        console.log(valid_address);
    }
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
    // initAutocomplete();
</script>

