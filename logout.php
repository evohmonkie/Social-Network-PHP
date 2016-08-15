<?php
session_start();

// Reset session to empty array
$_SESSION = array();

// Expire cookies
if(isset($_COOKIE["userid"]) && isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
	setcookie("userid", '', strtotime( '-5 days' ), '/');
    setcookie("username", '', strtotime( '-5 days' ), '/');
	setcookie("password", '', strtotime( '-5 days' ), '/');
}

// Destroy session variable
if(isset($_SESSION['username'])) {
	header('location: message.php?msg=Error:_Logout_Failed');
} else {
	header('location: login.php');
}
?>