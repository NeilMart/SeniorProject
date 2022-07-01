<?php

/*******************************************************************************
 * Connected to the login homepage, allows students to sign out assuming that 
 * they exist and also have not yet signed out 
 *
 * JS: checkIO.js
*******************************************************************************/

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

if (!isset($_REQUEST['id'])) {
	header('Location: ../index.html');
	exit();
}

$id     = $_REQUEST['id'];
$origin = $_SESSION['name'];

$query = "SELECT name FROM users WHERE username = '" . $origin . "'";
$check = mysqli_query($conn2, $query);
$originName = $check->fetch_array(MYSQLI_NUM);
$name = $originName[0];

$query = "SELECT origin FROM hallmonitor WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if (mysqli_num_rows($check) != 0) {
	$response[0] = false;
  $response[1] = "You've already checked out...";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

$query        = "SELECT name FROM student WHERE id = '" . $id . "'";
$blanketQuery = "SELECT * FROM hallmonitor";

$check = mysqli_query($conn, $query);
$total = mysqli_query($conn, $blanketQuery);

if (mysqli_num_rows($check) == 0) {
	$response[0] = false;
  $response[1] = "No student with that ID was found";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
} else if (mysqli_num_rows($total) < 10) {
	$query = "INSERT INTO hallmonitor (id, origin, destination, timeout) VALUES ('" . $id . "', '" . $name . "', '" . "TBD" . "', '" . 0000 . "')";
	mysqli_query($conn, $query);
	$_SESSION["id"] = $id;
	$response[0] = true;
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
} else {
	$response[0] = false;
  $response[1] = "The halls are full";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}
?>