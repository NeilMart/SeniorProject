<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'authentication';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_REQUEST['name']) ) {
	echo("You shouldn't be here");
	exit();
}

$name = $_REQUEST['name'];

if ($name == "default") {
  $response[0] = false;
  $response[1] = "Please select a username";
  $jsonResponse = json_encode($response);
  echo($jsonResponse);
  exit();
}

$query = "SELECT username FROM users WHERE username = '" . $name . "'";
$check = mysqli_query($conn, $query);

if (mysqli_num_rows($check) == 0) {
	$response[0] = false;
  $response[1] = "Username not found";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

$query = "DELETE FROM users WHERE username = '" . $name . "'";
$check = mysqli_query($conn, $query);

$response[0] = true;
$jsonResponse = json_encode($response);
echo($jsonResponse);

?>