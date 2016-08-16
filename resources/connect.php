<?php
// $database = "social_network";
// $servername = "localhost";
// $username = "root";
// $password = "monkies";
$database = "social_network";
$servername = getenv("REMOTE_ADDR");
$port = 3306;
$username = "evohmonkie";


// Connect to database
// $connect = mysqli_connect($servername, $username, $password, $database);
$connect = mysqli_connect($servername, $username, "", $database, $port);

// Check databse connection
if (!$connect) {
	die("connection failed: " . mysqli_connect_error());
} else {
	// echo "Connection successful!" . "<br />";
}

?>