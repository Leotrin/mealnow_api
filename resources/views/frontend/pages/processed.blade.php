@extends('layouts.master')

@section('content')
    <section  style="background: #eff3f6;padding:100px 0;">
        <div class="lp-section-row aliceblue text-center lp-section-content-container">
            <div class="container white mr-top-60 mr-bottom-60">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <p class="pg-404-p text-center padding-top-20"> Thank you ! </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center pad-top-15 padding-bottom-30">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <p>
                                    Thank you for choosing us as your Food & Drink service !
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section  style="background: #eff3f6;padding:10px 0;">
        <div class="container">
            <h3 class="text-center">new order </h3>
            <div class="lp-search-bar p20 borderRadiusCircle" style="opacity: 1 !important;position: relative;background: #fff;">
                @include('frontend.form.search')
            </div>
        </div>.
    </section>
@endsection