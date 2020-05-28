@extends('layouts.new_admin')

@section('content')

    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Shops</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item" >Shops</li>
            </ol>
        </div>

        <div id="accordion2">
            <div class="card mb-2">
                <div class="card-header">
                     <a class="d-flex justify-content-between text-dark btn btn-default @if(!isset($shop)) collapsed @endif" data-toggle="collapse" aria-expanded="@if(isset($shop)) true @else false @endif" href="#accordion2-1">@if(!isset($shop)) <span><i class="fa fa-plus"></i>Add New Shop</span> @else Edit Shop @endif <div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse @if(isset($shop)) show @endif" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(isset($shop))
                                {{ Form::model($shop, array('url' => '/admin/shops/edit/'.$shop->id , 'method'=>'post', 'class'=>'col-md-12', 'style'=>'padding:10px;', 'enctype'=>'multipart/form-data')) }}
                                <div class="col-md-4">
                                    <h3>Edit Shop</h3>
                                </div>
                                <div class="col-md-8 text-right">
                                    <img src="{{asset('images/shops/'.$shop->id.'/'.$shop->logo)}}" style="height:80px;" />
                                </div>
                                <div class="clearfix"></div>
                            @else
                                {{ Form::open(array('url' => '/admin/shops/add' , 'method'=>'post', 'class'=>'col-md-12', 'style'=>'padding:10px;border:1px solid #ccc;', 'enctype'=>'multipart/form-data')) }}
                                <h3>Register Shop</h3>
                            @endif
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Restaurant Name', 'required'=>'required')) }}
                            </div>
                                <div class="row">
                            <div class="col-6 form-group">
                                <label class="form-label">Description</label>
                                {{ Form::text('description', null, array('class'=>'form-control', 'placeholder'=>'Restaurant Short Description', 'required'=>'required')) }}
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Logo</label>
                                {{ Form::file('logo', null, array('required'=>'required')) }}
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">City</label>
                                {{ Form::hidden('country', null, array('id'=>'country')) }}
                                {{ Form::text('city', null, array('class'=>'form-control', 'placeholder'=>'City', 'required'=>'required', 'id'=>'locality')) }}
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Address</label>
                                {{ Form::text('address', null, array('class'=>'form-control', 'placeholder'=>'Search Address', 'required'=>'required' , 'id'=>'autocomplete', 'onFocus'=>'geolocate()')) }}
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Latitude, Longitude</label>
                                {{ Form::text('lat_long', null, array('class'=>'form-control', 'readonly'=>'readonly', 'placeholder'=>'Latitude, Longitude', 'required'=>'required', 'id'=>'geometry')) }}
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-6 form-group">
                                <label class="form-label">Tel</label>
                                {{ Form::text('tel', null, array('class'=>'form-control', 'placeholder'=>'Tel', 'required'=>'required')) }}
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Fax</label>
                                {{ Form::text('fax', null, array('class'=>'form-control', 'placeholder'=>'Fax', 'required'=>'required')) }}
                            </div>
                            <div class="col-6 form-group ">
                                <label class="form-label">E-Mail</label>
                                {{ Form::email('email', null, array('class'=>'form-control', 'placeholder'=>'Email', 'required'=>'required')) }}
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-6 form-group">
                                <label class="form-label">Delivery Time</label>
                                @if(isset($shop))
                                    {{ Form::text('delivery_time', null, null, array('class'=>'form-control', 'placeholder'=>'Delivery Time', 'required'=>'required')) }}
                                @else
                                    {{ Form::select('delivery_time', $times, null, array('class'=>'form-control', 'required'=>'required')) }}
                                @endif
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Delivery Price</label>
                                {{ Form::number('delivery_price', null, array('class'=>'form-control', 'placeholder'=>'0.0', 'min'=>'0', 'step'=>'0.5', 'required'=>'required')) }}
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Minimum Price</label>
                                {{ Form::number('min_price_order', null, array('class'=>'form-control', 'placeholder'=>'0.0', 'min'=>'0', 'step'=>'0.5', 'required'=>'required')) }}
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-6 form-group">
                                <label class="form-label">City <small>(used for search)</small></label>
                                {{ Form::text('search_city', null, array('class'=>'form-control', 'placeholder'=>'City to search for','required'=>'required')) }}
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-6 form-group">
                                <label class="form-label">Shop Account</label>
                                {{ Form::select('user_id', $users, null, array('class'=>'form-control', 'placeholder'=>'Select Account', 'required'=>'required')) }}
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Sales Account</label>
                                {{ Form::select('sales_id', $users, null, array('class'=>'form-control', 'placeholder'=>'Select Account', 'required'=>'required')) }}
                            </div>
                            <div class="col-6 form-group">
                                <label class="form-label">Representative Account</label>
                                {{ Form::select('representative_id', $users, null, array('class'=>'form-control', 'placeholder'=>'Select Account', 'required'=>'required')) }}
                            </div>
                            </div>

                            <div class="clearfix"></div>
                            @if(!isset($shop)) {{Form::submit('Save', array('class'=>'btn btn-primary pull-right'))}} @else {{Form::submit('Update', array('class'=>'btn btn-primary pull-right'))}} @endif
                            <a class="btn btn-danger" href="{!! url('admin/shops') !!}">Cancel</a>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h6 class="card-header">Shop's List</h6>
            <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table table-striped myTable" id="DataTables_Table_1" role="grid" >
                    <thead>
                    <tr>
                        <th>Shop</th>
                        <th>City</th>
                        <th>Delivery Time</th>
                        <th>Delivery Price</th>
                        <th>Minimum</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($shops as $item)
                        <tr class="odd gradeX">
                            <td>{{ $item->id }} - {{ $item->name }}</td>
                            <td>{{ $item->city }}</td>
                            <td>{{ $item->delivery_time }}</td>
                            <td>{{ $item->delivery_price }}</td>
                            <td>{{ $item->min_price_order }}</td>
                            <td class="center">{{ CD::status($item->status) }}</td>
                            <td class="center"  @if($item->status != 1) style="background:#a43e3c;" @endif>

                                @if(CD::checkPermission('ShopEditor'))
                                    <a href="{{ url('/admin/shops/edit/'.$item->id) }}" class="btn btn-info">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ url('/admin/shops/edit/'.$item->id) }}" class="btn btn-info">
                                        <i class="fa fa-home"></i>
                                    </a>
                                    @if($item->status != 1)
                                        <a href="{{ url('/admin/users/activate/'.$item->id) }}" class="btn btn-success">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    @else
                                        <a href="{{ url('/admin/users/delete/'.$item->id) }}" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endif
                                    <a href="{{ url('/admin/shop/'.$item->id.'/contact_methods') }}" title="Contact Methods" class="btn btn-info myTippy">
                                        <i class="far fa-comment-alt"></i>
                                    </a>
                                    <button type="button" data-toggle="modal" data-target="#shop_availability{!! $item->id !!}" class="btn btn-warning waves-effect">
                                        <i class="fas fa-clock"></i>
                                    </button>
                                    <div class="modal fade" id="shop_availability{!! $item->id !!}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{url('admin/shop/'.$item->id.'/availability')}}" method="post">
                                                    {{csrf_field()}}
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Shop Availability</h4>
                                                    </div>
                                                    <div class="modal-body text-left">
                                                        <?php
                                                        $availability = (object)json_decode($item->working_hours, true);
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-md-4 p10">
                                                                <label><input type="checkbox" name="monday"
                                                                              @if($availability!=null && isset($availability->monday)) checked @endif
                                                                    /> Monday</label>
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>From </label>
                                                                <input type="text" id="monday_hours_from" name="monday_hours_from"
                                                                       @if($availability!=null && isset($availability->monday))
                                                                       value="{{$availability->monday['hours_from']}}"
                                                                       @else
                                                                       value="00:00"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>To </label>
                                                                <input type="text" id="monday_hours_to" name="monday_hours_to"
                                                                       @if($availability!=null && isset($availability->monday))
                                                                       value="{{$availability->monday['hours_to']}}"
                                                                       @else
                                                                       value="23:59"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="clearfix"></div>

                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-4 p10">
                                                                <label><input type="checkbox" name="tuesday"
                                                                              @if($availability!=null && isset($availability->tuesday)) checked @endif
                                                                    /> Tuesday</label>
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>From </label>
                                                                <input type="text" name="tuesday_hours_from"
                                                                       @if($availability!=null && isset($availability->tuesday))
                                                                       value="{{$availability->tuesday['hours_from']}}"
                                                                       @else
                                                                       value="00:00"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>To </label>
                                                                <input type="text" name="tuesday_hours_to"
                                                                       @if($availability!=null && isset($availability->tuesday))
                                                                       value="{{$availability->tuesday['hours_to']}}"
                                                                       @else
                                                                       value="23:59"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                            <hr>
                                                        <div class="row">
                                                            <div class="col-md-4 p10">
                                                                <label><input type="checkbox" name="wednesday"
                                                                              @if($availability!=null && isset($availability->wednesday)) checked @endif
                                                                    /> Wednesday</label>
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>From </label>
                                                                <input type="text" name="wednesday_hours_from"
                                                                       @if($availability!=null && isset($availability->wednesday))
                                                                       value="{{$availability->wednesday['hours_from']}}"
                                                                       @else
                                                                       value="00:00"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>To </label>
                                                                <input type="text" name="wednesday_hours_to"
                                                                       @if($availability!=null && isset($availability->wednesday))
                                                                       value="{{$availability->wednesday['hours_to']}}"
                                                                       @else
                                                                       value="23:59"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                            <hr>
                                                        <div class="row">
                                                            <div class="col-md-4 p10">
                                                                <label><input type="checkbox" name="thursday"
                                                                              @if($availability!=null && isset($availability->thursday)) checked @endif
                                                                    /> Thursday</label>
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>From </label>
                                                                <input type="text" name="thursday_hours_from"
                                                                       @if($availability!=null && isset($availability->thursday))
                                                                       value="{{$availability->thursday['hours_from']}}"
                                                                       @else
                                                                       value="00:00"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>To </label>
                                                                <input type="text" name="thursday_hours_to"
                                                                       @if($availability!=null && isset($availability->thursday))
                                                                       value="{{$availability->thursday['hours_to']}}"
                                                                       @else
                                                                       value="23:59"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                            <hr>
                                                        <div class="row">
                                                            <div class="col-md-4 p10">
                                                                <label><input type="checkbox" name="friday"
                                                                              @if($availability!=null && isset($availability->friday)) checked @endif
                                                                    /> Friday</label>
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>From </label>
                                                                <input type="text" name="friday_hours_from"
                                                                       @if($availability!=null && isset($availability->friday))
                                                                       value="{{$availability->friday['hours_from']}}"
                                                                       @else
                                                                       value="00:00"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>To </label>
                                                                <input type="text" name="friday_hours_to"
                                                                       @if($availability!=null && isset($availability->friday))
                                                                       value="{{$availability->friday['hours_to']}}"
                                                                       @else
                                                                       value="23:59"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                            <hr>
                                                        <div class="row">
                                                            <div class="col-md-4 p10">
                                                                <label><input type="checkbox" name="saturday"
                                                                              @if($availability!=null && isset($availability->saturday)) checked @endif
                                                                    /> Saturday</label>
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>From </label>
                                                                <input type="text" name="saturday_hours_from"
                                                                       @if($availability!=null && isset($availability->saturday))
                                                                       value="{{$availability->saturday['hours_from']}}"
                                                                       @else
                                                                       value="00:00"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>To </label>
                                                                <input type="text" name="saturday_hours_to"
                                                                       @if($availability!=null && isset($availability->saturday))
                                                                       value="{{$availability->saturday['hours_to']}}"
                                                                       @else
                                                                       value="23:59"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                            <hr>
                                                        <div class="row">
                                                            <div class="col-md-4 p10">
                                                                <label><input type="checkbox" name="sunday"
                                                                              @if($availability!=null && isset($availability->sunday)) checked @endif
                                                                    /> Sunday</label>
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>From </label>
                                                                <input type="text" name="sunday_hours_from"
                                                                       @if($availability!=null && isset($availability->sunday))
                                                                       value="{{$availability->sunday['hours_from']}}"
                                                                       @else
                                                                       value="00:00"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="col-md-4 p5">
                                                                <label>To </label>
                                                                <input type="text" name="sunday_hours_to"
                                                                       @if($availability!=null && isset($availability->sunday))
                                                                       value="{{$availability->sunday['hours_to']}}"
                                                                       @else
                                                                       value="23:59"
                                                                       @endif
                                                                       class="form-control" />
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>

                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if(CD::checkPermission('MenuManagement'))
                                    <a href="{{ url('/admin/shop/'.$item->id.'/menu/create') }}" title="Menu Management" class="btn btn-primary myTippy">
                                        <i class="fab fa-elementor"></i>
                                    </a>
                                @endif
                                <a href="{{ url('/admin/shop/'.$item->id.'/additional_information') }}" title="Additioanl Information" class="btn btn-info myTippy">
                                    <i class="fas fa-info-circle"></i>
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







{{--    old design--}}
{{--    <div class="row-fluid" style="padding: 20px;">--}}
{{--        <div class="card">--}}
{{--            <div class="grid simple " style="padding:10px;">--}}
{{--                <div class="grid-title">--}}
{{--                    <h5><span class="semi-bold">Shops</span></h5> <br>--}}
{{--                    <h5><a class="text-dark" data-toggle="collapse" href="#CouponAccordion" aria-expanded="true">Shop manangement</a>--}}
{{--                    @if(isset($shop))--}}
{{--                            <a href="{!! url("/admin/shops") !!}"> or Change to Create shop</a>--}}
{{--                    @endif--}}
{{--                    </h5>--}}
{{--                </div>--}}
{{--                <div class="collapse hidden grid-body" id="CouponAccordion">--}}
{{--                    <div class="grid-body">--}}
{{--                        <div class="col-md-12" style="padding:0px;">--}}
{{--                            @if ($errors->any())--}}
{{--                                <div class="alert alert-danger">--}}
{{--                                    <ul>--}}
{{--                                        @foreach ($errors->all() as $error)--}}
{{--                                            <li>{{ $error }}</li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            @endif--}}

{{--                            @if(isset($shop))--}}
{{--                                {{ Form::model($shop, array('url' => '/admin/shops/edit/'.$shop->id , 'method'=>'post', 'class'=>'col-md-12', 'style'=>'padding:10px;border:1px solid #ccc;', 'enctype'=>'multipart/form-data')) }}--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <h3>Edit Shop</h3>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-8 text-right">--}}
{{--                                    <img src="{{asset('images/shops/'.$shop->id.'/'.$shop->logo)}}" style="height:80px;" />--}}
{{--                                </div>--}}
{{--                                <div class="clearfix"></div>--}}
{{--                            @else--}}
{{--                                {{ Form::open(array('url' => '/admin/shops/add' , 'method'=>'post', 'class'=>'col-md-12', 'style'=>'padding:10px;border:1px solid #ccc;', 'enctype'=>'multipart/form-data')) }}--}}
{{--                                <h3>Register Shop</h3>--}}
{{--                            @endif--}}

{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Name</label>--}}
{{--                                {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Restaurant Name', 'required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Description</label>--}}
{{--                                {{ Form::text('description', null, array('class'=>'form-control', 'placeholder'=>'Restaurant Short Description', 'required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Logo</label>--}}
{{--                                {{ Form::file('logo', null, array('required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="clearfix"></div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>City</label>--}}
{{--                                {{ Form::hidden('country', null, array('id'=>'country')) }}--}}
{{--                                {{ Form::text('city', null, array('class'=>'form-control', 'placeholder'=>'City', 'required'=>'required', 'id'=>'locality')) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Address</label>--}}
{{--                                {{ Form::text('address', null, array('class'=>'form-control', 'placeholder'=>'Search Address', 'required'=>'required' , 'id'=>'autocomplete', 'onFocus'=>'geolocate()')) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Latitude, Longitude</label>--}}
{{--                                {{ Form::text('lat_long', null, array('class'=>'form-control', 'readonly'=>'readonly', 'placeholder'=>'Latitude, Longitude', 'required'=>'required', 'id'=>'geometry')) }}--}}
{{--                            </div>--}}
{{--                            <div class="clearfix"></div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Tel</label>--}}
{{--                                {{ Form::text('tel', null, array('class'=>'form-control', 'placeholder'=>'Tel', 'required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Fax</label>--}}
{{--                                {{ Form::text('fax', null, array('class'=>'form-control', 'placeholder'=>'Fax', 'required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>E-Mail</label>--}}
{{--                                {{ Form::email('email', null, array('class'=>'form-control', 'placeholder'=>'Email', 'required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="clearfix"></div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Delivery Time</label>--}}
{{--                                @if(isset($shop))--}}
{{--                                    {{ Form::text('delivery_time', null, null, array('class'=>'form-control', 'placeholder'=>'Delivery Time', 'required'=>'required')) }}--}}
{{--                                @else--}}
{{--                                    {{ Form::select('delivery_time', $times, null, array('class'=>'form-control', 'required'=>'required')) }}--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Delivery Price</label>--}}
{{--                                {{ Form::number('delivery_price', null, array('class'=>'form-control', 'placeholder'=>'0.0', 'min'=>'0', 'step'=>'0.5', 'required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Minimum Price</label>--}}
{{--                                {{ Form::number('min_price_order', null, array('class'=>'form-control', 'placeholder'=>'0.0', 'min'=>'0', 'step'=>'0.5', 'required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="clearfix"></div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>City <small>(used for search)</small></label>--}}
{{--                                {{ Form::text('search_city', null, array('class'=>'form-control', 'placeholder'=>'City to search for','required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="clearfix"></div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Shop Account</label>--}}
{{--                                {{ Form::select('user_id', $users, null, array('class'=>'form-control', 'placeholder'=>'Select Account', 'required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Sales Account</label>--}}
{{--                                {{ Form::select('sales_id', $users, null, array('class'=>'form-control', 'placeholder'=>'Select Account', 'required'=>'required')) }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 p10">--}}
{{--                                <label>Representative Account</label>--}}
{{--                                {{ Form::select('representative_id', $users, null, array('class'=>'form-control', 'placeholder'=>'Select Account', 'required'=>'required')) }}--}}
{{--                            </div>--}}

{{--                            <div class="clearfix"></div>--}}
{{--                            {{Form::submit('Save', array('class'=>'btn btn-primary pull-right'))}}--}}
{{--                            {{ Form::close() }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="card">--}}
{{--            <h6 class="card-header">Support <span class="semi-bold">Tickets</span></h6>--}}
{{--            <div class="card-datatable table-responsive">--}}
{{--                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-sm-12">--}}
{{--                            <table class="table table-striped myTable" id="DataTables_Table_1" role="grid" >--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th>Shop</th>--}}
{{--                                    <th>City</th>--}}
{{--                                    <th>Delivery Time</th>--}}
{{--                                    <th>Delivery Price</th>--}}
{{--                                    <th>Minimum</th>--}}
{{--                                    <th>Status</th>--}}
{{--                                    <th>Options</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach($shops as $item)--}}
{{--                                    <tr class="odd gradeX">--}}
{{--                                        <td>{{ $item->id }} - {{ $item->name }}</td>--}}
{{--                                        <td>{{ $item->city }}</td>--}}
{{--                                        <td>{{ $item->delivery_time }}</td>--}}
{{--                                        <td>{{ $item->delivery_price }}</td>--}}
{{--                                        <td>{{ $item->min_price_order }}</td>--}}
{{--                                        <td class="center">{{ CD::status($item->status) }}</td>--}}
{{--                                        <td class="center"--}}
{{--                                            @if($item->status != 1)--}}
{{--                                            style="background:#a43e3c;"--}}
{{--                                                @endif--}}
{{--                                        >--}}

{{--                                            @if(CD::checkPermission('ShopEditor'))--}}
{{--                                                <a href="{{ url('/admin/shops/edit/'.$item->id) }}" class="btn btn-info">--}}
{{--                                                    <i class="fa fa-edit"></i>--}}
{{--                                                </a>--}}
{{--                                                @if($item->status != 1)--}}
{{--                                                    <a href="{{ url('/admin/users/activate/'.$item->id) }}" class="btn btn-success">--}}
{{--                                                        <i class="fas fa-check"></i>--}}
{{--                                                    </a>--}}
{{--                                                @else--}}
{{--                                                    <a href="{{ url('/admin/users/delete/'.$item->id) }}" class="btn btn-danger">--}}
{{--                                                        <i class="fa fa-trash"></i>--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                                <a href="{{ url('/admin/shop/'.$item->id.'/contact_methods') }}" title="Contact Methods" class="btn btn-info myTippy">--}}
{{--                                                    <i class="far fa-comment-alt"></i>--}}
{{--                                                </a>--}}
{{--                                                <button type="button" data-toggle="modal" data-target="#shop_availability{!! $item->id !!}" class="btn btn-warning waves-effect">--}}
{{--                                                    <i class="fas fa-clock"></i>--}}
{{--                                                </button>--}}
{{--                                                <div class="modal fade" id="shop_availability{!! $item->id !!}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
{{--                                                    <div class="modal-dialog" role="document">--}}
{{--                                                        <div class="modal-content">--}}
{{--                                                            <form action="{{url('admin/shop/'.$item->id.'/availability')}}" method="post">--}}
{{--                                                                {{csrf_field()}}--}}
{{--                                                                <div class="modal-header">--}}
{{--                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
{{--                                                                    <h4 class="modal-title" id="myModalLabel">Shop Availability</h4>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="modal-body text-left">--}}
{{--                                                                    <?php--}}
{{--                                                                    $availability = (object)json_decode($item->working_hours, true);--}}
{{--                                                                    ?>--}}
{{--                                                                    <div class="col-md-12 p10">--}}
{{--                                                                        <div class="col-md-4 p10">--}}
{{--                                                                            <label><input type="checkbox" name="monday"--}}
{{--                                                                                          @if($availability!=null && isset($availability->monday)) checked @endif--}}
{{--                                                                                /> Monday</label>--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>From </label>--}}
{{--                                                                            <input type="text" id="monday_hours_from" name="monday_hours_from"--}}
{{--                                                                                   @if($availability!=null && isset($availability->monday))--}}
{{--                                                                                   value="{{$availability->monday['hours_from']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="00:00"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>To </label>--}}
{{--                                                                            <input type="text" id="monday_hours_to" name="monday_hours_to"--}}
{{--                                                                                   @if($availability!=null && isset($availability->monday))--}}
{{--                                                                                   value="{{$availability->monday['hours_to']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="23:59"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="clearfix"></div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="col-md-12 p10">--}}
{{--                                                                        <div class="col-md-4 p10">--}}
{{--                                                                            <label><input type="checkbox" name="tuesday"--}}
{{--                                                                                          @if($availability!=null && isset($availability->tuesday)) checked @endif--}}
{{--                                                                                /> Tuesday</label>--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>From </label>--}}
{{--                                                                            <input type="text" name="tuesday_hours_from"--}}
{{--                                                                                   @if($availability!=null && isset($availability->tuesday))--}}
{{--                                                                                   value="{{$availability->tuesday['hours_from']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="00:00"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>To </label>--}}
{{--                                                                            <input type="text" name="tuesday_hours_to"--}}
{{--                                                                                   @if($availability!=null && isset($availability->tuesday))--}}
{{--                                                                                   value="{{$availability->tuesday['hours_to']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="23:59"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="clearfix"></div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="col-md-12 p10">--}}
{{--                                                                        <div class="col-md-4 p10">--}}
{{--                                                                            <label><input type="checkbox" name="wednesday"--}}
{{--                                                                                          @if($availability!=null && isset($availability->wednesday)) checked @endif--}}
{{--                                                                                /> Wednesday</label>--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>From </label>--}}
{{--                                                                            <input type="text" name="wednesday_hours_from"--}}
{{--                                                                                   @if($availability!=null && isset($availability->wednesday))--}}
{{--                                                                                   value="{{$availability->wednesday['hours_from']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="00:00"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>To </label>--}}
{{--                                                                            <input type="text" name="wednesday_hours_to"--}}
{{--                                                                                   @if($availability!=null && isset($availability->wednesday))--}}
{{--                                                                                   value="{{$availability->wednesday['hours_to']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="23:59"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="clearfix"></div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="col-md-12 p10">--}}
{{--                                                                        <div class="col-md-4 p10">--}}
{{--                                                                            <label><input type="checkbox" name="thursday"--}}
{{--                                                                                          @if($availability!=null && isset($availability->thursday)) checked @endif--}}
{{--                                                                                /> Thursday</label>--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>From </label>--}}
{{--                                                                            <input type="text" name="thursday_hours_from"--}}
{{--                                                                                   @if($availability!=null && isset($availability->thursday))--}}
{{--                                                                                   value="{{$availability->thursday['hours_from']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="00:00"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>To </label>--}}
{{--                                                                            <input type="text" name="thursday_hours_to"--}}
{{--                                                                                   @if($availability!=null && isset($availability->thursday))--}}
{{--                                                                                   value="{{$availability->thursday['hours_to']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="23:59"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="clearfix"></div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="col-md-12 p10">--}}
{{--                                                                        <div class="col-md-4 p10">--}}
{{--                                                                            <label><input type="checkbox" name="friday"--}}
{{--                                                                                          @if($availability!=null && isset($availability->friday)) checked @endif--}}
{{--                                                                                /> Friday</label>--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>From </label>--}}
{{--                                                                            <input type="text" name="friday_hours_from"--}}
{{--                                                                                   @if($availability!=null && isset($availability->friday))--}}
{{--                                                                                   value="{{$availability->friday['hours_from']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="00:00"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>To </label>--}}
{{--                                                                            <input type="text" name="friday_hours_to"--}}
{{--                                                                                   @if($availability!=null && isset($availability->friday))--}}
{{--                                                                                   value="{{$availability->friday['hours_to']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="23:59"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="clearfix"></div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="col-md-12 p10">--}}
{{--                                                                        <div class="col-md-4 p10">--}}
{{--                                                                            <label><input type="checkbox" name="saturday"--}}
{{--                                                                                          @if($availability!=null && isset($availability->saturday)) checked @endif--}}
{{--                                                                                /> Saturday</label>--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>From </label>--}}
{{--                                                                            <input type="text" name="saturday_hours_from"--}}
{{--                                                                                   @if($availability!=null && isset($availability->saturday))--}}
{{--                                                                                   value="{{$availability->saturday['hours_from']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="00:00"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>To </label>--}}
{{--                                                                            <input type="text" name="saturday_hours_to"--}}
{{--                                                                                   @if($availability!=null && isset($availability->saturday))--}}
{{--                                                                                   value="{{$availability->saturday['hours_to']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="23:59"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="clearfix"></div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="col-md-12 p10">--}}
{{--                                                                        <div class="col-md-4 p10">--}}
{{--                                                                            <label><input type="checkbox" name="sunday"--}}
{{--                                                                                          @if($availability!=null && isset($availability->sunday)) checked @endif--}}
{{--                                                                                /> Sunday</label>--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>From </label>--}}
{{--                                                                            <input type="text" name="sunday_hours_from"--}}
{{--                                                                                   @if($availability!=null && isset($availability->sunday))--}}
{{--                                                                                   value="{{$availability->sunday['hours_from']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="00:00"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="col-md-4 p5">--}}
{{--                                                                            <label>To </label>--}}
{{--                                                                            <input type="text" name="sunday_hours_to"--}}
{{--                                                                                   @if($availability!=null && isset($availability->sunday))--}}
{{--                                                                                   value="{{$availability->sunday['hours_to']}}"--}}
{{--                                                                                   @else--}}
{{--                                                                                   value="23:59"--}}
{{--                                                                                   @endif--}}
{{--                                                                                   class="form-control" />--}}
{{--                                                                        </div>--}}
{{--                                                                        <div class="clearfix"></div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <div class="clearfix"></div>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="modal-footer">--}}
{{--                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
{{--                                                                    <button type="submit" class="btn btn-primary">Save changes</button>--}}
{{--                                                                </div>--}}
{{--                                                            </form>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
{{--                                            @if(CD::checkPermission('MenuManagement'))--}}
{{--                                                <a href="{{ url('/admin/shop/'.$item->id.'/menu/create') }}" title="Menu Management" class="btn btn-primary myTippy">--}}
{{--                                                    <i class="fab fa-elementor"></i>--}}
{{--                                                </a>--}}
{{--                                            @endif--}}
{{--                                            <a href="{{ url('/admin/shop/'.$item->id.'/additional_information') }}" title="Additioanl Information" class="btn btn-info myTippy">--}}
{{--                                                <i class="fas fa-info-circle"></i>--}}
{{--                                            </a>--}}
{{--                                        </td>--}}

{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@section('footer')
    <script>
        var  autocomplete;
        var componentForm = {
            locality: 'long_name',
            country: 'long_name',
        };

        function initAutocomplete() {
            autocomplete = new google.maps.places.Autocomplete(
                (document.getElementById('autocomplete')),
                {types: ['geocode']});
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                fillInAddress();
            });
        }

        function fillInAddress() {

            var place = autocomplete.getPlace();
            for (var component in componentForm) {
                document.getElementById(component).value = '';
            }
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
            document.getElementById('geometry').value = place.geometry.location
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
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCi2RRL35my19HJgeI_N9z45XnI0WFCwck&libraries=places&callback=initAutocomplete" async defer></script>
@endsection
