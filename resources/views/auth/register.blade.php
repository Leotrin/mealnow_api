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
                        <div class="col-md-12 col-lg-12 mx-auto pl-5 pr-5">
                            <h3 class="login-heading mb-4">Welcome back!</h3>
                            <form class="form row" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                                    <label for="name" class="col-md-4 control-label">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? 'errors' : '' }} col-md-6">
                                    <label for="email" class="col-md-12 control-label">E-Mail Address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">
                                    <label for="password" class="col-md-12 control-label">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
                                    </div>
                                </div>
                                <div class="row p-10 " style="margin-top:65px;">
                                    <span class="text-center" style="margin: 0 auto;">Already have an account? <a href="{!! url('/login') !!}">Login Now</a></span>
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
