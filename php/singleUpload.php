<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'studentlist';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_REQUEST['name'], $_REQUEST['id']) ) {
	echo("You shouldn't be here");
	exit();
}

$name = $_REQUEST['name'];
$id   = $_REQUEST['id'];

$query = "SELECT name FROM student WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if (mysqli_num_rows($check) != 0) {
	$response[0] = false;
  $response[1] = "Student already in roster";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

$query = "INSERT INTO student (name, id) VALUES ('" . $name . "', '" . $id . "')";
$check = mysqli_query($conn, $query);

$response[0] = true;
$jsonResponse = json_encode($response);
echo($jsonResponse);

?>