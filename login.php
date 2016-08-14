<?php
include_once('resources/check_login_status.php');
if($user_ok == true) {
	header('location: user.php=?u'.$_SESSION['username']);
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Login | Social Network Tutorial</title>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<?php include_once('templates/top_nav.php'); ?>

	<!-- Login Form -->
	<form class="form-signin col-lg-2 col-lg-offset-5">
		<h2 class="form-signin-heading">Please Sign In</h2>
		<label class="sr-only" for="inputEmail">Email Address</label>
		<input class="form-control" id="inputEmail" placeholder="Email Address" autofocus="" type="email">
		<label class="sr-only" for="inputPassword">Password</label>
		<input class="form-control" id="inputPassword" placeholder="Password" autofocus="" type="email">
		<div class="checkbox">
			<label>
			<input value="remember-me" type="checkbox"></input>Remeber my login
			</label>
		</div>
		<button type="submit" class="btn btn-primary btn-block">Sign In</button>
	</form>

</body>
<footer>
	<?php include_once('templates/footer_page.php'); ?>

	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/main.js"></script>
</footer>
</html>