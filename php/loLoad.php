<?php

/*******************************************************************************
 * When the location selection page opens, this dynamically throws the name of
 * the student checking out onto the screen ... hopefully the teacher pays
 * enough attention to notice anyone using the incorrect ID
 * 
 * JS: location.js
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

// This is a different method of parameter existence checking, though it worked
// well for this specific application
if (!isset($_SESSION["id"])) {
  $response[0] = false;
  $encodedResponse = json_encode($response);
  echo($encodedResponse);
  exit();
}

$id = $_SESSION["id"];

// This uses the student's ID to grab their name from the database
$query = "SELECT name FROM student WHERE id = $id";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
  die("could not execute statement $query<br />");
}

$results = $check->fetch_array(MYSQLI_NUM);

$response[0] = true;
$response[1] = $results[0];
$encodedResponse = json_encode($response);
echo($encodedResponse);

?>