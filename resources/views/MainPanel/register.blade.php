<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

	<title>Registration</title>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-md-12 col-md-offset-4">
				<h1 class="text-center mt-5">Registration</h1>
				<hr>
				<form>
					
					@csrf

					<div id="result"></div>

					<div class="d-flex align-items-center justify-content-center mb-3 row">
					    <label for="user_id" class="col-sm-2 col-form-label">Id</label>
					    <div class="col-sm-5">
							<input type="text" name="user_id" class="form-control" placeholder="Enter Your Id" value="{{old('user_id')}}">
					    </div>
					    <span class="text-center text-danger" id="error_user_id"></span>
					</div>
					<div class="d-flex align-items-center justify-content-center mb-3 row">
					    <label for="fname" class="col-sm-2 col-form-label">First Name</label>
					    <div class="col-sm-5">
							<input type="text" name="fname" class="form-control" placeholder="Enter Your First Name" value="{{old('fname')}}">
					    </div>
					    <span class="text-center text-danger" id="error_fname"></span>
					</div>
					<div class="d-flex align-items-center justify-content-center mb-3 row">
					    <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
					    <div class="col-sm-5">
							<input type="text" name="lname" class="form-control" placeholder="Enter Your Last Name" value="{{old('lname')}}">
					    </div>
					    <span class="text-center text-danger" id="error_lname"></span>
					</div>
					<div class="d-flex align-items-center justify-content-center mb-3 row">
					    <label for="email" class="col-sm-2 col-form-label">Email</label>
					    <div class="col-sm-5">
							<input type="email" name="email" class="form-control" placeholder="Enter Your Email Address" value="{{old('email')}}">
					    </div>
					    <span class="text-center text-danger" id="error_email"></span>
					</div>
					<div class="d-flex align-items-center justify-content-center mb-3 row">
					    <label for="password" class="col-sm-2 col-form-label">Password</label>
					    <div class="col-sm-5">
					      <input type="password" name="password" class="form-control" id="password" placeholder="Enter Your Password" value="{{old('password')}}">
						  <i>6 to 20 characters</i>
					    </div>
					    <span class="text-center text-danger" id="error_password"></span>
					</div>
					<div class="form-group text-center">
					  	<button class="btn btn-block btn-primary" id="register" type="submit">Register</button>
					</div>
					<br>
					<a class="d-flex align-items-center justify-content-center" href="/login">Already have an account!</a>
				</form>
			</div>
		</div>
	</div>

	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
	<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script>
		$('#register').on('click', function (e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: "api/register-user",
				data: {
					user_id: $('input[name=user_id]').val(),
					fname: $('input[name=fname]').val(),
					lname: $('input[name=lname]').val(),
					email: $('input[name=email]').val(),
					password: $('input[name=password]').val()
				},
				success: function (response) {
					if (response.validation_error) {
						$('#error_user_id').text(response.errors['user_id']);
						$('#error_fname').text(response.errors['fname']);
						$('#error_lname').text(response.errors['lname']);
						$('#error_email').text(response.errors['email']);
						$('#error_password').text(response.errors['password']);
					} else if (response.success) {
						$('#result').html('<div class="alert alert-success" id="success">Registered Successfully :)</div>');
					} else {
						$('#result').html('<div class="alert alert-danger" id="danger">Something went wrong :(</div>');
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