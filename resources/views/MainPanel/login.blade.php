<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

	<title>Login</title>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-12 col-md-offset-4">
				<h1 class="text-center mt-5">Login</h1>
				<hr>
				<form>

					@csrf

					<div id="result"></div>

					<div class="d-flex align-items-center justify-content-center mb-3 row">
					    <label for="email" class="col-sm-2 col-form-label">Email</label>
					    <div class="col-sm-5">
							<input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Enter Your Email Address">
					    </div>
						<span class="text-center text-danger" id="error_email"></span>
					</div>
					<div class="d-flex align-items-center justify-content-center mb-3 row">
					    <label for="password" class="col-sm-2 col-form-label">Password</label>
					    <div class="col-sm-5">
					      <input type="password" name="password" class="form-control" id="password" value="{{old('password')}}" placeholder="Enter Your Password">
					    </div>
						<span class="text-center text-danger" id="error_password"></span>
					</div>
					<div class="form-group text-center">
					  	<button class="btn btn-block btn-primary" id="login" type="submit">Login</button>
					</div>
					<br>
					<a class="d-flex align-items-center justify-content-center" href="/register">Don't have an account?</a>
				</form>
			</div>
		</div>
	</div>

	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
	<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script>
		$('#login').on('click', function (e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "api/login-user",
				data: {
					email: $('#email').val(),
					password: $('#password').val()
				},
				success: function (response) {
					if (response.validation_error) {
						$('#error_email').text(response.errors['email']);
						$('#error_password').text(response.errors['password']);
					} else if (response.password_error == true) {
						$('#result').html('<div class="alert alert-danger" id="danger">Password does not match</div>');
					} else if(response.email_address_unregistered == true) {
						$('#result').html('<div class="alert alert-danger" id="danger">Invalid Email Address</div>');
					} else {
						if (response.role == "Employeer") {
							location.href = 'emp_index';
						} else {
							location.href = 'sup_index';
						}
					}
				},
				error: function (err) { 
					console.log(err);
				}
			});
		});
	</script>
</body>
</html>