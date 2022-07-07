<?php

/*******************************************************************************
 * Used to remove anyone that exited the queue using a non "happy path" ... ran
 * everytime the login homepage is loaded
 * 
 * JS: checkIO.js
 ******************************************************************************/

session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'studentlist';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$conn2 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, 'authentication');
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Don't really want to try and grab a variable that doesn't exist
if (!isset($_SESSION['name'])) {
	header('Location: ../index.html');
	exit();
}

$origin = $_SESSION['name'];

// My PHP session only stores the username, which is sometimes less useful to me
// than the actual name it is associated with... this grabs that name from the
// database
$query = "SELECT name FROM users WHERE username = '" . $origin . "'";
$check = mysqli_query($conn2, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$originName = $check->fetch_array(MYSQLI_NUM);
$name = $originName[0];

// Lets say the laptop dies while a student is choose a destination - they'll no
// longer be able to check in or out ... trapped, alone ... this fixes that,
// cleaning things up everytime its associated page is ran
$query = "DELETE FROM hallmonitor WHERE destination = '" . "TBD" . "' AND origin = '" . $name . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

// There's probably an ID floating around in the session too, so lets make sure
// that gets fixed
if (isset($_SESSION["id"])) {
  unset($_SESSION["id"]);
}
?>