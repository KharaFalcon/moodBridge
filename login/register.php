<?php include("includes/header.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<?php include("includes/nav.php") ?>

<div class="row">
	<div class="col-lg-6 col-lg-offset-3">

		<?php validate_user_registration(); ?>

	</div>


</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-login">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-6">
						<a href="login.php">Login</a>
					</div>
					<div class="col-xs-6">
						<a href="register.php" class="active" id="">Register</a>
					</div>
				</div>
				<hr>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<form id="register-form" method="post" role="form">
							<div class="form-group">
								<input type="text" name="FirstName" id="FirstName" tabindex="1" class="form-control" placeholder="First Name" value="" required>
							</div>
							<div class="form-group">
								<input type="text" name="LastName" id="LastName" tabindex="1" class="form-control" placeholder="Last Name" value="" required>
							</div>
							<div class="form-group">
								<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" required>
							</div>
							<div class="form-group">
								<input type="email" name="email" id="register_email" tabindex="1" class="form-control" placeholder="Email Address" value="" required>
							</div>
							<div class="form-group">
								<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
							</div>
							<div class="form-group">
								<input type="password" name="confirm_password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" required>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3">
										<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-6">
						<img src="animatedlogin.png" alt="Your Image" class="img-responsive">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("includes/footer.php") ?>