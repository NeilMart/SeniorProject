<?php

/*****************************************************************************
 * Grabs the names of all authenticated users, displaying them dynamically on
 * the location selection drop-down menu
 * 
 * JS: location.js
 ****************************************************************************/

session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'authentication';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Don't really want to try and grab a variable that doesn't exist
if (!isset($_SESSION["name"])) {
	header('Location: ../index.html');
	exit();
}

$name = $_SESSION['name'];

// Grabs all of the users that are both not the current user and not the office 
// staff
$stmt = "SELECT name FROM users WHERE username != '" . $name . "' AND username != '" . "admin" . "' ORDER BY name";
$result = mysqli_query($conn, $stmt);

if ($result == FALSE) { 
  die ("could not execute statement $stmt<br />");
}

// Creates an array that is made up of all of the current staff member's names
$output = array();
while ($row = $result->fetch_row()) {
  array_push($output, $row);
}

$enocdedOutput = json_encode($output);
echo($enocdedOutput);
?>