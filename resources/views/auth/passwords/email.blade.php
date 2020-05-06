<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Askbootstrap">
    <meta name="author" content="Askbootstrap">
    <title>{{ config('app.name') }}</title>
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
    <!-- END CSS TEMPLATE -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="bg-white">
<div class="container-fluid">
    <div class="row no-gutter">
        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
        <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 col-lg-8 mx-auto pl-5 pr-5">
                            <div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
                                <h2 class="normal">
                                    <a href="{{url('/')}}">{{ config('app.name') }}</a>  Sign in</h2>
                                <p>
                                    Use your email to login in our system.
                                    <br>
                                </p>
                                <p class="p-b-20">
                                    <a href="{{ route('register') }}">
                                        Register now ! For an account in {{ config('app.name') }} .
                                    </a>
                                </p>
                                <a href="{{ route('login') }}" class="btn btn-primary btn-cons">Sign in</a> <br/>
                                or <br/>
                                <a href="{{ route('register') }}" class="btn btn-info btn-cons"> Create an account</a>

                                @if (session('status'))
                                    <br />
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                            <br/>
                            <span> Send a link to reset the password</span>
                            <hr/>
                            <div class="tiles grey p-t-20 p-b-20 text-black">
                                <form class="animated fadeIn" id="frm_login" method="POST" action="{{ route('password.email') }}">
                                    {{ csrf_field() }}
                                    <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                        <div class="col-md-6 col-sm-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <input name="email" id="login_username" type="email" value="{{ old('email') }}" class="form-control" placeholder="E-Mail Address" required autofocus>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-sm-6 text-right">
                                            <button type="submit" class="btn btn-info btn-cons">
                                               Send
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="/new_front/vendor/jquery/jquery-3.3.1.slim.min.js"></script>
<!-- Bootstrap core JavaScript-->
<script src="/new_front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 JavaScript-->
<script src="/new_front/vendor/select2/js/select2.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="/new_front/js/custom.js"></script>
</body>


</html>

