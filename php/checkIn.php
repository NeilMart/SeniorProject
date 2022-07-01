<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'studentlist';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_REQUEST['id']) ) {
	exit("You shouldn't be here");
}

$id     = $_REQUEST['id'];
$origin = $_SESSION['name'];

$DATABASE_H = 'localhost';
$DATABASE_U = 'root';
$DATABASE_P = 'TiwIsamd8ta.';
$DATABASE_N = 'authentication';

$conn2 = mysqli_connect($DATABASE_H, $DATABASE_U, $DATABASE_P, $DATABASE_N);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$query = "SELECT name FROM users WHERE username = '" . $origin . "'";
$check = mysqli_query($conn2, $query);
$originName = $check->fetch_array(MYSQLI_NUM);
$name = $originName[0];

$query = "SELECT id FROM hallmonitor WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if (mysqli_num_rows($check) == 0) {
	$response[0] = false;
  $response[1] = "You haven't checked out yet";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

$query = "SELECT origin FROM hallmonitor WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);
$databaseOrigin = $check->fetch_array(MYSQLI_NUM);

$query = "SELECT destination FROM hallmonitor WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);
$databaseDestination = $check->fetch_array(MYSQLI_NUM);

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