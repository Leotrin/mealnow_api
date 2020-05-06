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
  <link rel="icon" type="image/png" href="/new_front/img/favicon.png">
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
