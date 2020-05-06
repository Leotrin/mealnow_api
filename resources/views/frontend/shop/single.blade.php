@extends('layouts.master')

@section('content')
    @include('frontend.shop.details')
@endsection

@section('footer')


    @if($cart!=null && isset($cart['service']['type']) && $cart['service']['type']=='delivery')
        <?php
        $total = $cart['total'] + $cart['service']['price'];

        ?>
        <script>
            var total_price_to_check  = <?= number_format($total,2); ?>;
        </script>
    @elseif($cart!=null)
        <script>
            var total_price_to_check  = {{$cart['total']}};
        </script>
    @else
        <script>
            var total_price_to_check  = 0;
        </script>
    @endif
    <script>
        $(document).ready(function(){
            $('#serviceType').html('{{$schedule['service']}}');
        });
    </script>
    <script>
        var baseUrl = '{{url('frontend/shop/'.$shop->id)}}';
        var minimum_delivery_price_to_check = {{ $shop->min_price_order }};
        var menuJson =   {!! json_encode($menu['items']) !!};
        // $(document).ready(function(){
        //     $('#addToCart').css('height',window.innerHeight);
        // });
    </script>
    <script src="/front/pickadate/picker.js"></script>
    <script src="/front/pickadate/picker.date.js"></script>
{{--    <script src="/assets/plugins/google_maps_api.js"></script>--}}
    <script src="/js/order.js"></script>
    @include('frontend.shop.cart.schedule')
    {{--@include('frontend.shop.cart.address')--}}
    @include('frontend.shop.closed')


@endsection