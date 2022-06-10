<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'studentlist';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_REQUEST['id']) ) {
	echo("You shouldn't be here");
	exit();
}

$id   = $_REQUEST['id'];

$query = "SELECT name FROM student WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if (mysqli_num_rows($check) == 0) {
	$response[0] = false;
  $response[1] = "No student with that ID was found";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

$query = "DELETE FROM student WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

$response[0] = true;
$jsonResponse = json_encode($response);
echo($jsonResponse);

?>