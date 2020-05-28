@extends('layouts.new_admin')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Shop's Additional Info</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! url('/admin') !!}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item" ><a href="{!! url('/admin/shops') !!}"> Shops</a></li>
                <li class="breadcrumb-item" >Aditional Info</li>
            </ol>
        </div>

        <div class="card">
            <h6 class="card-header">Shop's Additional Info List</h6>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <div class="col-md-12" style="padding:10px;border:1px solid #ccc;">
                        <h4>{{$shop->name}}</h4>
                        <p>
                            {{$shop->description}}
                            <br />
                            City to search for : {{$shop->search_city}}
                            <br />
                            {{$shop->address}}, {{$shop->city}}
                            <br />
                            <span class="label label-default">{{$shop->lat_long}}</span>
                            <br />
                            Tel: {{$shop->tel}}
                            <br />
                            Fax: {{$shop->fax}}
                            <br />
                            E-Mail: {{$shop->email}}
                            <br />
                            <br />
                            Minimum price: <strong>{{$shop->min_price_order}} $</strong>
                            <br />
                            Delivery price: <strong>{{$shop->delivery_price}} $</strong>
                            <br />
                            Delivery time: <strong>{{$shop->delivery_time}} min</strong>
                        </p>
                        @if($shop->representative_id!=0 && $shop->representative_id!=null)
                            <p>
                                Representative : <strong>{{$shop->representative->name}}</strong>
                            </p>
                        @endif
                        @if($shop->sales_id!=0 && $shop->sales_id!=null)
                            <p>
                                Sales Account : <strong>{{$shop->sale->name}}</strong>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <br/><br/>
        <div class="card">
            <h6 class="card-header">Change Additional Info</h6>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <div class="col-md-12" style="padding:0;">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{ Form::model($shop->moreInfo, array('url' => '/admin/shop/'.$shop->id.'/additional_information' , 'method'=>'post', 'class'=>'col-md-12', 'style'=>'padding:10px;border:1px solid #ccc;', 'enctype'=>'multipart/form-data')) }}
                        <h4>Additional Information</h4>
                        <div class="col-md-4 p10 form-group">
                            <label class="form-label">Manager Account</label>
                            {{ Form::select('manager', $users, null, array('class'=>'form-control', 'placeholder'=>'Manager Account', 'required'=>'required')) }}
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Menu Representative</label>
                            {{ Form::select('menu_representativ', $users, null, array('class'=>'form-control', 'placeholder'=>'Menu Representative', 'required'=>'required')) }}
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Chain's</label>
                            {{ Form::select('chain', $shops, null, array('class'=>'form-control', 'placeholder'=>'No Chains')) }}
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Sub Domain</label>
                            {{ Form::text('subdomain', null, array('class'=>'form-control', 'placeholder'=>'subdomain.mealnow.com','required'=>'required')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Google My Business Domain</label>
                            {{ Form::text('my_business_domain', null, array('class'=>'form-control', 'placeholder'=>'Google My Business Domain')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Account</label>
                            {{ Form::text('account', null, array('class'=>'form-control', 'placeholder'=>'Email address')) }}
                        </div>
                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Account Password</label>
                            {{ Form::text('account_password', null, array('class'=>'form-control', 'placeholder'=>'Password')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Banner</label>
                            {{ Form::file('banner', null, array('class'=>'form-control')) }}
                        </div>
                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Banner Text</label>
                            {{ Form::text('banner_text', null, array('class'=>'form-control', 'placeholder'=>'Banner Text')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Pickup time estimate</label>
                            {{ Form::text('pickup_estimate', null, array('class'=>'form-control', 'placeholder'=>'0 - 15 min')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Processing Fee</label>
                            {{ Form::number('processing_fee', null, array('class'=>'form-control','min'=>0.00, 'step'=>0.01,'placeholder'=>'0.00')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Payment Type</label>
                            {{ Form::select('payment_type', ['Simple'=>'Simple','Detailed'=>'Detailed'], null, array('class'=>'form-control', 'placeholder'=>'Not defined')) }}
                        </div>
                        <div class="col-md-6 p10">
                            <label class="form-label">Payment Frequency</label>
                            {{ Form::select('payment_frequency', ['Monthly'=>'Monthly','Semimonthly'=>'Semimonthly','Weekly'=>'Weekly'], null, array('class'=>'form-control', 'placeholder'=>'Not defined')) }}
                        </div>

                        <div class="col-md-6 p10">
                            <label class="form-label">SEO HTML Meta Tags</label>
                            {{ Form::textarea('seo_meta_tags', null, array('class'=>'form-control', 'style'=>'min-width:100%;max-width:100%;min-height:100px;height:100px;')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Keywords</label>
                            {{ Form::textarea('keywords', null, array('class'=>'form-control', 'style'=>'min-width:100%;max-width:100%;min-height:100px;height:100px;')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Description</label>
                            {{ Form::textarea('description', null, array('class'=>'form-control', 'style'=>'min-width:100%;max-width:100%;min-height:100px;height:100px;')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">Mailing Address</label>
                            {{ Form::textarea('mailing_address', null, array('class'=>'form-control', 'style'=>'min-width:100%;max-width:100%;min-height:60px;height:60px;')) }}
                        </div>

                        <div class="col-md-6 p10 form-group">
                            <label class="form-label">More Additional information</label>
                            {{ Form::textarea('more_info', null, array('class'=>'form-control', 'style'=>'min-width:100%;max-width:100%;min-height:60px;height:60px;')) }}
                        </div>

                        <div class="col-md-12 p10 form-group">
                            {{Form::submit('Save', array('class'=>'btn btn-primary pull-right'))}}

                        </div>
                            <div class="clearfix"></div>
                            {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>






{{--    OLD DESIGN--}}
{{--    <div class="row-fluid">--}}
{{--        <div class="span12">--}}
{{--            <div class="grid simple " style="padding: 10px;">--}}
{{--                <div class="grid-title">--}}
{{--                    <a class="text-dark" data-toggle="collapse" href="#addInfoAccordion" aria-expanded="true"><h4>{{$shop->name}} <span class="semi-bold">manangement</span></h4></a>--}}
{{--                </div>--}}
{{--                <div id="addInfoAccordion" class="collapse show grid-body">--}}
{{--                   --}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row-fluid">--}}
{{--        <div class="span12">--}}
{{--            <div class="grid simple ">--}}
{{--                <div class="grid-title">--}}
{{--                    <a class="text-dark" data-toggle="collapse" href="#addInfoLogActivityAccordion" aria-expanded="true"> <h4>Log <span class="semi-bold">activity</span></h4></a>--}}
{{--                </div>--}}
{{--                <div id="addInfoLogActivityAccordion" class="collapse hidden grid-body" style="display: none;">--}}
{{--                    <div class="col-md-12" style="padding:0px;">--}}
{{--                        <div class="col-md-12">--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
