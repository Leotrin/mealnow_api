@extends('layouts.master')

@section('content')
<!-- top Links -->
<div class="top-links">
    <div class="container">
       <ul class="row links">
          <li class="col-xs-12 col-sm-3 link-item"><span>1</span><a href="/">Choose Your Location</a></li>
          <li class="col-xs-12 col-sm-3 link-item"><span>2</span><a href="/frontend/shops">Choose Restaurant</a></li>
          <li class="col-xs-12 col-sm-3 link-item "><span>3</span><a href="../">Pick Your favorite food</a></li>
          <li class="col-xs-12 col-sm-3 link-item active" style="padding:0 15px"><span>4</span><a href="#">Order and Pay online</a></li>
       </ul>
    </div>
 </div>
 <!-- end:Top links -->
    <section  style="background: #fafafa;padding:8% 0;">
        
            <div class="col-md-8 page-container p0">
                <section style="padding:0px 0px;font-size:14px;">
                        {{ Form::open(array('url'=>url('/frontend/shop/'.$shop->id.'/checkout/register') , 'method'=>'post' ,
                                            'class'=>'col-md-6 col-md-offset-3',
                                            'enctype'=>'multipart/form-data')) }}
                        <h3 class="text-center" style="color:#888;">
                            Personal Information
                        </h3>
                        <div class="col-md-12 p0 mb5">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 p0 mb5">
                            <label for="male"  class="radioLabelRegister" >
                                {{ Form::radio('gender', 1, true,['id'=>'male']) }} Mr
                                <span class="radioCheckmarkRegister"></span>
                            </label>
                            <label for="female" class="radioLabelRegister" >
                                {{ Form::radio('gender', 2, false,['id'=>'female']) }} Mrs
                                <span class="radioCheckmarkRegister"></span>
                            </label>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-12 p0 mb5">
                            <label>Full Name</label>
                            {{ Form::text('name', null, array('class'=>'form-control')) }}
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-12 p0 mb5">
                            <label>E-mail</label>
                            {{ Form::email('email', null, array('class'=>'form-control')) }}
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-12 p0 mb5">
                            <label>City</label>
                            {{ Form::text('city', null, array('class'=>'form-control')) }}
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-12 p0 mb5">
                            <div class="col-md-3 p0">
                                <label>Zip Code</label>
                                {{ Form::number('zip', null, array('class'=>'form-control')) }}
                            </div>
                            <div class="col-md-8 col-md-offset-1 p0">
                                <label>Address</label>
                                {{ Form::text('address', null, array('class'=>'form-control')) }}
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-12 p0 mb5">
                            <label>Tel</label>
                            {{ Form::number('tel', null, array('class'=>'form-control')) }}
                            <div class="clearfix"></div>
                        </div>
                        <br />
                        <div class="col-md-12 p0 text-right">
                            {{Form::submit('Save & Continue', array('class'=>'btn btn-primary'))}}
                            <div class="clearfix"></div>
                        </div>
                    {{ Form::close() }}
                    <div class="clearfix"></div>
                </section>
            </div>
            <div class="col-md-3 page-container p0"style="padding-right:">
                @include('frontend.shop.cart.cartPreview')
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
    </section>
@endsection

@section('footer')

    <script>
        var baseUrl = '{{url('frontend/shop/'.$shop->id)}}';
    </script>
    <script src="{{asset('js/order.js')}}"></script>
@endsection