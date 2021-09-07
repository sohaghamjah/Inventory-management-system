
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uiwebsoft.com/justlog/login-nine/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Aug 2020 00:36:10 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('settings.title') ? config('settings.title') : env('APP_NAME') }} - Login</title>
    <!-- External CSS -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/login/assets/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/login/assets/fonts/font-awesome/css/font-awesome.min.css') }}">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ 'storage/'.LOGO_PATH.config('settings.favicon') }}" type="image/x-icon">
 
    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/login/login-nine/css/login-nine.css') }}">

</head>
<body>

<!-- Loader -->
<div class="loader"><div class="loader_div"></div></div>

<!-- Login page -->
<div class="login_wrapper">
    <div class="row no-gutters">

        <div class="col-md-6 mobile-hidden">
            <div class="login_left">
                <div class="login_left_img"><img src="assets/login/login-nine/images/login-bg.jpg" alt="login background"></div>
            </div>
        </div>
        <div class="col-md-6 bg-white">
            <div class="login_box">
                     <a href="{{ url('/') }}" class="logo_text">
                        <img class="dt-brand__logo-symbol" style="width: 250px" src="{{ asset('storage/'.LOGO_PATH.config('settings.logo')) }}"alt="IMS">
                    </a>
                    <div class="login_form">
                        <div class="login_form_inner">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="input-text @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                                    <i class="fa fa-envelope"></i>
                                    <span class="focus-border"></span>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="input-text @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                    <i class="fa fa-lock"></i>
                                    <span class="focus-border"></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="checkbox clearfix">
                                    <div class="form-check checkbox-theme">
                                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rememberMe">
                                            Remember me
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                      <a href="{{ route('password.request') }}">Forgot Password</a>
                                    @endif
                                </div>
                                    <button type="submit" class="btn-md btn-theme btn-block">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</div>
<!-- /. Login page -->


<!-- External JS libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- Custom JS Script -->
<script type="text/javascript">

	var $window = $(window);

        // :: Preloader Active Code
        $window.on('load', function () {
            $('.loader').fadeOut('slow', function () {
                $(this).remove();
            });
        });
</script>

</body>

<!-- Mirrored from uiwebsoft.com/justlog/login-nine/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 29 Aug 2020 00:36:12 GMT -->
</html>