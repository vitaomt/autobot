<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login - {{ config('app.title') }}</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{ asset('resources/views/default/images/icons/favicon.ico') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/vendor/animate/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/vendor/css-hamburgers/hamburgers.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/vendor/animsition/css/animsition.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/vendor/select2/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/vendor/daterangepicker/daterangepicker.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/default/css/main2.css') }}">
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form method="post" action="{{ route('login') }}" class="login100-form validate-form">
					@csrf
					<span class="login100-form-title p-b-43">
						Welcome
					</span>

					<div class="wrap-input100 validate-input">
						<input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="" required autocomplete="off">

						<span class="focus-input100" data-placeholder="E-mail"></span>
						<span class="label-input100">Email</span>
                    </div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="off">
						<span class="focus-input100" data-placeholder="Password"></span>
						<span class="label-input100">Password</span>
                    </div>

					@error('email')
                        <div class="alert" style="color: #c74450!important;background: transparent;border-color: #f5c6cb!important" role="alert"><center>{{ $message }}</center></div>
					@enderror

                    @error('password')
                        <div class="alert" style="color: #c74450!important;background: transparent;border-color: #f5c6cb!important" role="alert"><center>{{ $message }}</center></div>
                    @enderror

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="label-checkbox100" for="remember">
                                {{ __('Remember Me') }}
                            </label>
						</div>

						<!-- <div>
							<a href="#" class="txt1">
								Forgot Password?
							</a>
						</div> -->
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>
					
					<div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							<a href="{{ url('register') }}">Don’t have an account? Sign Up</a>
						</span>
					</div>
				</form>

				<div class="login100-more" style="background-image: url({{ asset('resources/views/default/images/bg-01.jpg') }})"></div>
			</div>
		</div>
	</div>

	<script src="{{ asset('resources/views/default/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('resources/views/default/vendor/animsition/js/animsition.min.js') }}"></script>
	<script src="{{ asset('resources/views/default/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('resources/views/default/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('resources/views/default/vendor/select2/select2.min.js') }}"></script>
	<script src="{{ asset('resources/views/default/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('resources/views/default/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('resources/views/default/vendor/countdowntime/countdowntime.js') }}"></script>
	<script src="{{ asset('resources/views/default/js/main.js') }}"></script>
</body>
</html>