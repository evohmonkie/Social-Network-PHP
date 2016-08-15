<?php
// Check if user is already logged in
include_once('resources/check_login_status.php');

//Initialize variables for user page
$u = "";
$sex = "";
$userlevel = "";
$country = "";
$joindate = "";
$lastlogin = "";
$website = "";

// Set _GET username
if (isset($_GET['u'])) {
	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
} else {
	header('location: index.php');
	exit();
}

// Check if user is also the owner
$isOwner = false;
if ($u == $log_username && $user_ok == true) {
	$isOwner = true;
}

// Grab User info from database;
$sql = "SELECT * FROM users WHERE username='$u' LIMIT 1";
$query = mysqli_query($connect, $sql);
if (mysqli_num_rows($query) < 1) {
	echo "User does not exist";
	exit();
}

while ($row = mysqli_fetch_assoc($query)) {
	$userid = $row['id'];
	if($row['gender'] == "f") {
		$gender = "Female";
	} else {
		$gender = "Male";
	}
	
	$country = $row['country'];
	$userlevel = $row['userlevel'];
	$joindate = $row['signup'];
	$lastlogin = $row['lastlogin'];
	$website = $row['website'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>User | Social Network Tutorial</title>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<?php include_once('templates/top_nav.php'); ?>

	<div class="container">
		<div class="page-header">
			<h1><?php echo ucfirst($u); ?></h1>
		</div>
	</div>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">User Information</h3>
			</div>
			<div class="panel-body">
				<?php
					echo 
					$userid."<br />".
					$gender."<br />".
					$country."<br />".
					$userlevel."<br />".
					$website."<br />".
					$lastlogin."<br />".
					$joindate."<br />"
				?>
			</div>
		</div>
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