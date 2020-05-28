@extends('layouts.master')

@section('content')
    <section class="offer-dedicated-body pt-2 pb-2 mt-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="offer-dedicated-body-left">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-order-online" role="tabpanel" aria-labelledby="pills-order-online-tab">
                                <div class="row">
                                    {{ Form::open(array('url'=>url('frontend/shop/'.$shop->id.'/checkout/register') , 'method'=>'post' ,
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
                                        <label>Zip Code</label>
                                        {{ Form::number('zip', null, array('class'=>'form-control')) }}
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-md-12 p0 mb5">
                                        <label>Address</label>
                                        {{ Form::text('address', null, array('class'=>'form-control')) }}
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" >
                                           @include('frontend.shop.cart.cartPreview')

                </div>
            </div>
        </div>
    </section>

@endsection

@section('footer')
    <script>
        var baseUrl = '{{url('/frontend/shop/'.$shop->id)}}';
    </script>
    <script src="{{asset('js/order.js')}}"></script>
@endsection
