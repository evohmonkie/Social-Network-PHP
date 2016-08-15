<?php
// Check if user is already logged in
include_once('resources/check_login_status.php');
if($user_ok == true) {
	header('location: user.php?u='.$_SESSION['username']);
	exit();
}
?>

<?php
// AJAX calls this script to execute login
if (isset($_POST['e'])) {
	session_start();
	include_once('resources/connect.php');
	$e = mysqli_real_escape_string($connect, $_POST['e']);
	$p = $_POST['p'];
	$save = $_POST['save'];
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

	$query = "SELECT id, username, password FROM users WHERE email='$e' AND activated='1' LIMIT 1";
	$checkLogin = mysqli_query($connect, $query);
	$row = mysqli_fetch_assoc($checkLogin);

	// Check login data against database
	if (mysqli_num_rows($checkLogin) < 1 || $row['password'] != $p) {
		echo "login_failed";
		exit();
	} else {
		// Login Successful: Create session and cookies
		$db_userid = $row['id'];
		$db_username = $row['username'];
		$db_password = $row['password'];

		$_SESSION['userid'] = $db_userid;
		$_SESSION['username'] = $db_username;
		$_SESSION['password'] = $db_password;

		if ($save == "on") {
			setcookie("userid", $db_userid, strtotime('+30 days'), "/", "", "", TRUE);
			setcookie("username", $db_username, strtotime('+30 days'), "/", "", "", TRUE);
			setcookie("password", $db_password, strtotime('+30 days'), "/", "", "", TRUE);
		}

		// Update login in information
		$sql = "UPDATE users SET lastlogin=now(), ip='$ip' WHERE id='$db_userid' LIMIT 1";
		$query = mysqli_query($connect, $sql);

		echo $_SESSION['username'];
		exit();
	}
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
	<div class="container col-md-4 col-md-offset-4">
		<form class="form-signin">
			<h2 class="form-signin-heading">Please Sign In</h2>
			<label class="sr-only" for="inputEmail">Email Address</label>
			<input class="form-control" id="inputEmail" placeholder="Email Address" type="email" onfocus="emptyElement('login-msg')">
			<label class="sr-only" for="inputPassword">Password</label>
			<input class="form-control" id="inputPassword" placeholder="Password" type="password" onfocus="emptyElement('login-msg')">
			<div class="checkbox">
				<label>
				<input id="remember-me" type="checkbox"></input>Remeber my login
				</label>
			</div>
		</form>
		<button class="btn btn-primary btn-block" id="login-btn" onclick="login()">Sign In</button>
		<span id="login-msg"></span>
	</div>

</body>
<footer>
	<?php include_once('templates/footer_page.php'); ?>

	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/main.js"></script>
</footer>
</html>