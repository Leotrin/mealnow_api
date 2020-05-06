<script>
    var valid_address = null;
    lat = null;
    lng = null;
</script>
    <div class="modal fade" id="deliveryAddressOrder" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Delivery Address</h4>
            </div>
            <div class="modal-body">
                <strong>
                    Please enter the delivery address.
                </strong>
                <hr />
                <style>
                    .pac-container {
                        z-index: 1051 !important;
                    }
                </style>
                <div class="col-md-12 p5" style="padding-top: 0;">
                    <label for="address_input"><i class="fa fa-user"></i> Name</label>
                    <br />
                    <input type="text" name="name_input" placeholder="Enter name" id="name_input" class="form-control"
                            @if(\Illuminate\Support\Facades\Auth::check())
                                value="{{auth()->user()->name}}"
                            @endif
                           required />
                </div>
                <div class="col-md-12 p5" style="padding-top: 0;">
                    <label for="address_input"><i class="fa fa-map-marker"></i> Address</label>
                    <br />

                    <input type="text" name="address_input" placeholder="Enter Address" id="address_input" class="form-control"
                           onFocus="geolocate()" />
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 p10 text-center">
                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" onClick="changeAddress(valid_address, lat, lng, '{{$shop->lat_long}}')">Save</button>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
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
                initAutocomplete();
            </script>

        </div>
    </div>
</div>