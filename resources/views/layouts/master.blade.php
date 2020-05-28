<!DOCTYPE html>
<html>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script> window.Laravel = { csrfToken: '{{ csrf_token() }}'  } </script>
  <!-- Favicon Icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{!! asset('assets/favicons/apple-icon-57x57.png') !!}">
    <link rel="apple-touch-icon" sizes="60x60" href="{!! asset('assets/favicons/apple-icon-60x60.png') !!}">
    <link rel="apple-touch-icon" sizes="72x72" href="{!! asset('assets/favicons/apple-icon-72x72.png') !!}">
    <link rel="apple-touch-icon" sizes="76x76" href="{!! asset('assets/favicons/apple-icon-76x76.png') !!}">
    <link rel="apple-touch-icon" sizes="114x114" href="{!! asset('assets/favicons/apple-icon-114x114.png') !!}">
    <link rel="apple-touch-icon" sizes="120x120" href="{!! asset('assets/favicons/apple-icon-120x120.png') !!}">
    <link rel="apple-touch-icon" sizes="144x144" href="{!! asset('assets/favicons/apple-icon-144x144.png') !!}">
    <link rel="apple-touch-icon" sizes="152x152" href="{!! asset('assets/favicons/apple-icon-152x152.png') !!}">
    <link rel="apple-touch-icon" sizes="180x180" href="{!! asset('assets/favicons/apple-icon-180x180.png') !!}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{!! asset('assets/favicons/android-icon-192x192.png') !!}">
    <link rel="icon" type="image/png" sizes="32x32" href="{!! asset('assets/favicons/favicon-32x32.png') !!}">
    <link rel="icon" type="image/png" sizes="96x96" href="{!! asset('assets/favicons/favicon-96x96.png') !!}">
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/favicons/favicon-16x16.png') !!}">
  <!-- Bootstrap core CSS-->
  <link href="/new_front/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome-->
  <link href="/new_front/vendor/fontawesome/css/all.min.css" rel="stylesheet">
  <!-- Font Awesome-->
  <link href="/new_front/vendor/icofont/icofont.min.css" rel="stylesheet">
  <!-- Select2 CSS-->
  <link href="/new_front/vendor/select2/css/select2.min.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="/new_front/css/osahan.css" rel="stylesheet">
  <link href="/new_front/css/custom.css" rel="stylesheet">
  <!-- Owl Carousel -->
  <link rel="stylesheet" href="/new_front/vendor/owl-carousel/owl.carousel.css">
  <link rel="stylesheet" href="/new_front/vendor/owl-carousel/owl.theme.css">
    <link rel="stylesheet" src="/front/pickadate/compressed/themes/default.css">
{{--    <link rel="stylesheet" src="/front/pickadate/compressed/themes/default.date.css">--}}
    <link rel="stylesheet" src="/front/pickadate/compressed/themes/default.time.css">

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>

  @include("frontend.layouts.nav")
  @yield("content")
  @include("frontend.layouts.footer")



<!-- jQuery -->
  <script src="/js/app.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- Bootstrap core JavaScript-->
<script src="/new_front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 JavaScript-->
<script src="/new_front/vendor/select2/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="/new_front/vendor/owl-carousel/owl.carousel.js"></script>

@yield("footer")
<!-- Custom scripts for all pages-->
<script src="/front/js/sweetalert2.min.js"></script>
{{--<script src="/front/js/singlepostmap.js"></script>--}}
<script src="/new_front/js/custom.js"></script>

  <script>
    function changeServiceSelected(){
      var checked = $('#searchPickupDelivery:checked');
      if(checked.length>0){
        $('#pickupSearchLabel').removeClass('selectedServiceSearch');
        $('#deliverySearchLabel').addClass('selectedServiceSearch');
      }else{
        $('#deliverySearchLabel').removeClass('selectedServiceSearch');
        $('#pickupSearchLabel').addClass('selectedServiceSearch');
      }
    }
  </script>

</body>
</html>
