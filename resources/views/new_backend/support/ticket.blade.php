
@extends('layouts.new_admin')

@section('head')
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{ asset('assets/plugins/bootstrap-select2/select2.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <!-- END PLUGIN CSS -->
@endsection

@section('content')


    <div class="row">
        <div class="col-md">
            <div class="card text-center mb-3">
                <div class="card-header bg-primary border-0">
                    <ul class="nav nav-pills md-pills-light card-header-pills nav-responsive-md">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#navs-li"> Last Informations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#navs-c">Communications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#navs-ap"> Action protocol</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-li">
                        <div class="card-body">
                            @include('backend.support.parts.info')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-c">
                        <div class="card-body">
                            @include('backend.support.parts.msg')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-ap">
                        <div class="card-body">
                            @include('backend.support.parts.log')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



{{--<style>--}}
{{--    .menuBox {--}}
{{--        padding:15px 20px 20px 20px;--}}
{{--        background: #ccc;--}}
{{--        border:1px solid #888;--}}
{{--        width:60px;--}}
{{--        height:60px;--}}
{{--        margin:auto;--}}
{{--        border-radius:50%;--}}
{{--    }--}}
{{--    .activeMenuBox {--}}
{{--        background: #4778b5;--}}
{{--        color:#fff;--}}
{{--    }--}}
{{--    .activeMenuText {--}}
{{--        border-bottom:2px solid #4778b5;--}}
{{--    }--}}
{{--    .linkBox {--}}
{{--        cursor: pointer;--}}
{{--    }--}}
{{--    .hideBox {--}}
{{--        display: none;--}}
{{--    }--}}
{{--    .showBox {--}}
{{--        display: block;--}}
{{--    }--}}
{{--</style>--}}
{{--<div class="col-md-12 p10">--}}
{{--    <div class="panel panel-default">--}}
{{--        <div class="panel-heading">Details {{ $ticket->subject }} {{ $ticket->id }}</div>--}}
{{--        <div class="panel-body p0" style="background: #fff;">--}}
{{--            <div class="col-md-12 p10" style="background: #efefef;">--}}
{{--                <div class="col-md-4 text-center linkBox" onClick="showBox('Info')">--}}
{{--                    <p id="boxInfo" class="menuBox activeMenuBox">--}}
{{--                        <i class="fa fa-question fa-2x"></i>--}}
{{--                    </p>--}}
{{--                    <br />--}}
{{--                    <span id="textInfo" class="activeMenuText">--}}
{{--                        Last Informations--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 text-center linkBox" onClick="showBox('Msg')">--}}
{{--                    <p id="boxMsg" class="menuBox" style="padding-left:17px;">--}}
{{--                        <i class="fa fa-envelope fa-2x"></i>--}}
{{--                    </p>--}}
{{--                    <br />--}}
{{--                    <span id="textMsg">--}}
{{--                        Communications--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--                <div class="col-md-4 text-center linkBox" onClick="showBox('Log')">--}}
{{--                    <p id="boxLog"  class="menuBox">--}}
{{--                        <i class="fa fa-file fa-2x"></i>--}}
{{--                    </p>--}}
{{--                    <br />--}}
{{--                    <span id="textLog">--}}
{{--                        Action protocol--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--            </div>--}}


{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

@endsection

@section('footer')
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{ asset('assets/plugins/jquery-block-ui/jqueryblockui.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-select2/select2.min.js') }}" type="text/javascript"></script>

    <script>
        function showBox(box){
            $('.activeMenuBox').removeClass('activeMenuBox');
            $('.activeMenuText').removeClass('activeMenuText');
            $('.hideBox').removeClass('hideBox');
            var boxi = 'box'+box;
            var texti = 'text'+box;
            $('.hideBox').removeClass('hideBox');
            $('.boxed').addClass('hideBox');
            $('#'+box).removeClass('hideBox');

            $('#'+boxi).addClass('activeMenuBox');
            $('#'+texti).addClass('activeMenuText');
        }
    </script>
@endsection
