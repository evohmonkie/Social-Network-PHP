<?php
session_start();
//If user is logged in, header them away
if (isset($_SESSION['username'])) {
	header('location: message.php?msg=Already logged in');
	exit();
}
?>

<?php
// AJAX to check username
if(isset($_POST['usernamecheck'])) {

	include_once('resources/connect.php');
	// Clean and store username for checking
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	// $username = $_POST['usernamecheck'];

	$query = "SELECT id FROM users WHERE username = '$username' LIMIT 1";
	$checkDB = mysqli_query($connect, $query);
	$row = mysqli_num_rows($checkDB);
	if (strlen($username) < 3 || strlen($username) > 16) {
		echo "<strong style='color:#f00'>Username must be between 3 - 16 characters</strong>";
		exit();
	}
	if (is_numeric($username[0])) {
		echo "<strong style='color:#f00'>Username must begin with a letter</strong>";
		exit();
	}
	if ($row < 1) {
		echo "<strong style='color:#009900'>Username is ok!</strong>";
		exit();
	}
	if ($row > 0) {
		echo "<strong style='color:#f00'>Username is unavailable</strong>";
		exit();
	}
}
?>

<?php
// AJAX for creating new user
if(isset($_POST['u'])){

	include_once('resources/connect.php');
	// Gather data in local variables
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($connect, $_POST['e']);
	$p = $_POST['p'];
	$g = preg_replace('#[^a-z]#', '', $_POST['g']);
	$c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
	// Get user IP address
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

	// Check for duplicate email and username
	$query = "SELECT id FROM users WHERE username = '$u' LIMIT 1";
	$checkDB = mysqli_query($connect, $query);
	$u_check = mysqli_num_rows($checkDB);
	
	$query = "SELECT id FROM users WHERE email = '$e' LIMIT 1";
	$checkDB = mysqli_query($connect, $query);
	$e_check = mysqli_num_rows($checkDB);;

	// Database checks
	if ($u == "" || $e == "" || $p == "" || $g == "" || $c == "") {
		echo "<strong style='color:#f00'>Form is missing values</strong>";
		exit();
	}
	elseif ($u_check > 0) {
		echo "<strong style='color:#f00'>Username is unavailable</strong>";
		exit();
	}
	elseif (strlen($u) < 3 || strlen($u) > 16) {
		echo "<strong style='color:#f00'>Username must be between 3 - 16 characters</strong>";
		exit();
	}
	elseif (is_numeric($u[0])) {
		echo "<strong style='color:#f00'>Username must begin with a letter</strong>";
		exit();
	}
	// elseif ($e_check > 0) {
	// 	echo "<strong style='color:#f00'>Email address is already registered</strong>";
	// 	exit();
	// }
	// ALL datbase checks pass!! Create the new user here
	else {
		// $cryptpass = crypt($p);
		// include_once('resources/randStrGen.php');
		// $p_hashed = randStrGen(20)."$cryptpass".randStrGen(20);
		
		// Insert new user into database
		$query = "INSERT INTO users (username, email, password, gender, country, ip, signup, lastlogin, notescheck) VALUES ('$u', '$e', '$p', '$g', '$c', 'ip', now(), now(), now())";
		$insertNewUser = mysqli_query($connect, $query);
		
		// Create new folder for user profile
		if (!file_exists("users/$u")) {
			mkdir("users/$u", 0755);
		}
		
		// Send activation email
		$recipient = "$e";
		$sender = "evohmonkie@gmail.com";
		$subject = "Please activate account";
		$message = "Click link to activate account";
		$headers = "From: $sender\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        if (mail($recipient, $subject, $message, $headers)){
        	echo "signup_success";
        	exit();
        } else {
       		echo $recipient . "<br />";
	        echo $sender . "<br />";
	        echo $subject . "<br />";
	        echo $message . "<br />";
	        echo $headers . "<br />";
			exit();
        }
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>SocialNetwork | Registration</title>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">	
</head>
<body>
	<?php include_once('templates/top_nav.php'); ?>

	<!-- Sign up form (FYI below)
		onblur = when user stops interacting with input field
		onkeyup = when user releases a key press
		onfocus = when user focuses on element
	-->
	<form class="col-md-6" id="signup-form">
		<div class="form-group">
			<label for="username">Username</label>
			<input class="form-control" type="text" id="username" placeholder="username" onblur="checkUsername()" onkeyup="restrict("username")" maxlength="16">
			<span id="username-status"></span>
		</div>
		<div class="form-group">
			<label for="password1">Create Password</label>
			<input class="form-control" type="password" id="password1" placeholder="password" onfocus="emptyElement('form-status')" maxlength="16">
		</div>
		<div class="form-group">
			<label for="password2">Confirm Password</label>
			<input class="form-control" type="password" id="password2" placeholder="password" onfocus="emptyElement('form-status')" maxlength="16">
		</div>
		<div class="form-group">
			<label for="email">Email Address</label>
			<input class="form-control" type="email" id="email" placeholder="name@example.com" onfocus="emptyElement('form-status')" onkeyup="restrict('email')" maxlength="88">
		</div>
		<div class="form-group">
			<label for="gender">Gender</label>
			<select class="form-control" id="gender">
				<option value=""></option>
				<option value="m">Male</option>
				<option value="f">Female</option>
			</select>
		</div>
		<div class="form-group">
			<label for="country">Country</label>
			<select class="form-control" id="country">
				<option value="usa">United States</option>
			</select>
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" id="terms"> Check if you agree.
			</label>
		</div>

	</form>
		<span id="form-status"></span><!-- Returns message when user clicks form --> 
		<button class="btn btn-primary" id="signup-btn" onclick="signup()">Create Account</button>

</body>
<footer>
	<?php include_once('templates/footer_page.php'); ?>
	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/main.js"></script>
</footer>
</html>