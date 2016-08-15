<?php
session_start();
include_once('connect.php');

// Initiate variables for user check
$user_ok = false;
$log_id = "";
$log_username = "";
$log_password = "";

function evalLoggedUser($con, $id, $u, $p) {
	$sql = "SELECT ip FROM users WHERE id='$id' AND username='$u' AND password='$p' AND activated='1' LIMIT 1";
	$query = mysqli_query($con, $sql);
	if (mysqli_num_rows($query) > 0) {
		return true;
	}
}

// Retrieve session values and compare with database values
if (isset($_SESSION['userid']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
	$log_id = preg_replace('#[^0-9]#', '', $_SESSION['userid']);
	$log_username = preg_replace('#[^a-z0-9]#i', '', $_SESSION['username']);
	$log_password = preg_replace('#[^a-z0-9]#i', '', $_SESSION['password']);

	// Verify user
	$user_ok = evalLoggedUser($connect, $log_id, $log_username, $log_password);

} elseif (isset($_COOKIE['userid']) && isset($_COOKIE['username']) && isset($_COOKIE['password'])) {

	$_SESSION['userid'] = preg_replace('#[^0-9]#', '', $_COOKIE['userid']);
    $_SESSION['username'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['username']);
    $_SESSION['password'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['password']);

	$log_id = $_SESSION['userid'];
	$log_username = $_SESSION['username'];
	$log_password = $_SESSION['password'];

	$user_ok = evalLoggedUser($connect, $log_id, $log_username, $log_password);

	// Update lastlogin
	$sql = "UPDATE users SET lastlogin=now() WHERE id='$log_id' LIMIT 1";
	$query = mysqli_query($connect, $sql);
}

?>