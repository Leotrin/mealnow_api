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
                            <h3 class="login-heading mb-4">Welcome back!</h3>
                            <form class="animated fadeIn" id="frm_login" method="POST" action="{{ route('password.request') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                    <div class="col-md-6 col-sm-6 {{ $errors->has('email') ? 'errors' : '' }}">
                                        <input name="email" id="login_username" type="email" value="{{ old('email') }}" class="form-control" placeholder="E-Mail Address" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                    <div class="col-md-6 col-sm-6 {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <input name="password" id="login_pass" type="password" class="form-control" placeholder="Password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-sm-6 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <input name="password_confirmation" id="login_pass" type="password" class="form-control" placeholder="Confirm Password" required>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                                    <div class="col-md-6 col-sm-6 text-right">
                                        <button type="submit" class="btn btn-primary">
                                            Change Password
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

