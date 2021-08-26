<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Mini Bank</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset('/assets/login2/images/icons/favicon.ico') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/login2/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/login2/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/login2/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/login2/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/login2/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/login2/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/login2/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/login2/css/main.css') }}">
<!--===============================================================================================-->
<script>
    if ( window.history.replaceState ) {
        lokasi = "{{ url('login') }}";
        window.history.replaceState( null, null, lokasi);
    }
</script>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('{{ asset('/assets/login2/images/img-01.jpeg') }}');">
			<div class="wrap-login100 p-t-100 p-b-30">
				<form class="login100-form validate-form" action="{{ url('/auth') }}" method="post">
				<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
					<div class="login100-form-avatar" style="padding-top:13px; padding-left:10px;">
						<img src="{{ asset('/assets/logosmk.gif') }}" alt="AVATAR" style="width:100px;">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						Mini BANK <br>
						SMK YPC Tasikmalaya
					</span>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username"  autocomplete="new-password" autofill="off">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password"  autocomplete="new-password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center w-full p-t-25 p-b-230">

					</div>

					<div class="text-center w-full">
						<a class="txt1" href="#">
							Create new account
							<i class="fa fa-long-arrow-right"></i>						
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="{{ asset('/assets/login2/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('/assets/login2/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('/assets/login2/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('/assets/login2/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="js/main.js') }}"></script>

</body>
</html>