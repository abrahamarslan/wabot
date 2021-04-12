<!DOCTYPE html>
<html lang="en">
@include('themes.default._partials.header')
<body class="authentication-bg">
<div class="account-pages mt-5 mb-5" id="app">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="text-center">
                    <a href="#" class="logo">
                        <img src="{!! asset('themes/default/assets/images/logo-light.png') !!}" alt="" height="22" class="logo-light mx-auto">
                        <img src="{!! asset('themes/default/images/logo-dark.png') !!}" alt="" height="22" class="logo-dark mx-auto">
                    </a>
                    <p class="text-muted mt-2 mb-4">Responsive Admin Dashboard</p>
                </div>
                <div class="card">

                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <h4 class="text-uppercase mt-0">Sign In</h4>
                        </div>

                        {!! Form::open(['route' => 'authentication.login.create', 'method' => 'POST', 'class' => 'form', 'novalidate' => 'novalidate']) !!}
                        {!! Form::token() !!}

                            <div class="form-group mb-3">
                                <label for="emailaddress">Email address</label>
                                {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'login-username', 'autocomplete' => 'off'] ) !!}
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                {!! Form::password('password',['class' => 'form-control', 'id' => 'login-password', 'autocomplete' => 'off']) !!}
                            </div>

                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="login_remember" class="custom-control-input" id="checkbox-signin" checked>
                                    <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Log In </button>
                            </div>

                        {!! Form::close() !!}

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p> <a href="pages-recoverpw.html" class="text-muted ml-1"><i class="fa fa-lock mr-1"></i>Forgot your password?</a></p>
                        <p class="text-muted">Don't have an account? <a href="pages-register.html" class="text-dark ml-1"><b>Sign Up</b></a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
    @include('themes.default._partials.notification')
</div>
<!-- end page -->
@include('themes.default._partials.scripts')
</body>
</html>
