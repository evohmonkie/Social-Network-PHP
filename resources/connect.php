<?php
$database = "social_network";
$servername = "localhost";
$username = "root";
$password = "monkies";

// Connect to database
$connect = mysqli_connect($servername, $username, $password, $database);

// Check databse connection
if (!$connect) {
	die("connection failed: " . mysqli_connect_error());
} else {
	// echo "Connection successful!" . "<br />";
}

?>