<?php

include('connect.php');

// Create Users
$createUsers = "CREATE TABLE users(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(16) NOT NULL,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	gender ENUM('m', 'f') NOT NULL,
	website VARCHAR(255) NULL,
	country VARCHAR(255) NULL,
	userlevel ENUM('a', 'b', 'c', 'd') NOT NULL DEFAULT 'a',
	avatar VARCHAR(255) NULL,
	ip VARCHAR(255) NOT NULL,
	signup DATETIME NOT NULL,
	lastlogin DATETIME NOT NULL,
	notescheck DATETIME NOT NULL,
	activated ENUM('0', '1') NOT NULL DEFAULT '0',
	UNIQUE KEY username(username, email)
)";

if (mysqli_query($connect, $createUsers)) {
	echo "Sucessfully TABLE created users" . "<br />";
} else {
	echo "Failed to create TABLE users: " . mysqli_error($connect) . "<br />";
}

// Create User Options
$createUserOptions = "CREATE TABLE useroptions(
	id INT(11) NOT NULL PRIMARY KEY,
	username VARCHAR(16) NOT NULL,
	background VARCHAR(255) NOT NULL,
	question VARCHAR(255) NOT NULL,
	answer VARCHAR(255) NOT NULL,
	UNIQUE KEY username(username)
)";

if (mysqli_query($connect, $createUserOptions)) {
	echo "Sucessfully created TABLE useroptions" . "<br />";
} else {
	echo "Failed to create TABLE useroptions: " . mysqli_error($connect) . "<br />";
}

// Create Friends
$createFriends = "CREATE TABLE friends(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user1 VARCHAR(16) NOT NULL,
	user2 VARCHAR(16) NOT NULL,
	datemade DATETIME NOT NULL,
	accepted ENUM('0', '1') NOT NULL DEFAULT '0'
)";

if (mysqli_query($connect, $createFriends)) {
	echo "Sucessfully created TABLE friends" . "<br />";
} else {
	echo "Failed to create TABLE friends: " . mysqli_error($connect) . "<br />";
}

// Create Blocked Friends
$createBlockedFriends = "CREATE TABLE blockedusers(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	blocker VARCHAR(16) NOT NULL,
	blockee VARCHAR(16) NOT NULL,
	blockdate DATETIME NOT NULL
)";

if (mysqli_query($connect, $createBlockedFriends)) {
	echo "Sucessfully created TABLE blockedusers" . "<br />";
} else {
	echo "Failed to create TABLE blockedusers: " . mysqli_error($connect) . "<br />";
}

// Create Status
$createPost = "CREATE TABLE posts(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	osid INT(11) NOT NULL,
	account_name VARCHAR(16) NOT NULL,
	author VARCHAR(16) NOT NULL,
	type ENUM('a', 'b', 'c') NOT NULL,
	data TEXT NOT NULL,
	postdate DATETIME NOT NULL
)";

if (mysqli_query($connect, $createPost)) {
	echo "Sucessfully created TABLE posts" . "<br />";
} else {
	echo "Failed to create TABLE posts: " . mysqli_error($connect) . "<br />";
}

// CREATE Photos
$createPhotos = "CREATE TABLE photos(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(16) NOT NULL,
	gallery VARCHAR(16) NOT NULL,
	description VARCHAR(255) NOT NULL,
	uploaddate DATETIME NOT NULL
)";

if (mysqli_query($connect, $createPhotos)) {
	echo "Sucessfully created TABLE photos" . "<br />";
} else {
	echo "Failed to create TABLE photos: " . mysqli_error($connect) . "<br />";
}

// Create notifications
$createNotifications = "CREATE TABLE notifications(
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(16) NOT NULL,
	initiator VARCHAR(16) NOT NULL,
	app VARCHAR(255) NOT NULL,
	note VARCHAR(255) NOT NULL,
	did_read ENUM('0', '1') NOT NULL DEFAULT '0',
	date_time DATETIME NOT NULL
)";

if (mysqli_query($connect, $createNotifications)) {
	echo "Sucessfully created TABLE notifications" . "<br />";
} else {
	echo "Failed to create TABLE notifications: " . mysqli_error($connect) . "<br />";
}
?>