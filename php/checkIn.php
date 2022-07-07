<?php

/*******************************************************************************
 * Connected to the login homepage, allows students that have checked out to
 * check back in
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
if (!isset($_REQUEST['id'], $_SESSION['name'])) {
	header('Location: ../index.html');
	exit();
}

$id     = $_REQUEST['id'];
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

// Check to see if a student with the inputted ID is actually in the halls
$query = "SELECT id FROM hallmonitor WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

// If my query didn't return anything, this student must not have checked out
// yet ... hopefully
if (mysqli_num_rows($check) == 0) {
	$response[0] = false;
  $response[1] = "You haven't checked out yet";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

// Using the now confirmed ID, find out where the student is coming from
$query = "SELECT origin FROM hallmonitor WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$databaseOrigin = $check->fetch_array(MYSQLI_NUM);

// and where they wanted to go
$query = "SELECT destination FROM hallmonitor WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$databaseDestination = $check->fetch_array(MYSQLI_NUM);

// There are two scenarios in which a student is allowed to check in ... either
// they ended up where they started, or they ended up where they said they were
// going ... note that for the case of things such as a bathroom trip, they have
// to check back in at their origin
if ($name == $databaseOrigin[0] || $name == $databaseDestination[0]) {
	$response[0] = true;
	$jsonResponse = json_encode($response);

	$query = "DELETE FROM hallmonitor WHERE id = '" . $id . "'";
	$check = mysqli_query($conn, $query);

	echo($jsonResponse);
} else {
	$response[0] = false;
	$response[1] = "You cannot check into this room";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
}
?>