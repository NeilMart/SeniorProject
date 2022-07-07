<?php

/*******************************************************************************
 * Used to remove a staff member's account from the list of authenticated users
 * 
 * JS: viewStaff.js
 ******************************************************************************/

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'authentication';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Don't really want to try and grab a variable that doesn't exist
if (!isset($_REQUEST['name'])) {
	echo('Location: ../index.html');
	exit();
}

$name = $_REQUEST['name'];

// Uses the provided name to find the username of the teacher that we are
// looking to remove
$query = "SELECT username FROM users WHERE username = '" . $name . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
  die ("could not execute statement $query<br />");
}

// If the provided name did not return a username, the given user must not exist
if (mysqli_num_rows($check) == 0) {
	$response[0] = false;
  $response[1] = "Username not found";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

// Now that we know this staff member is a real person, it is time to make them
// a not real person
$query = "DELETE FROM users WHERE username = '" . $name . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
  die ("could not execute statement $query<br />");
}

$response[0] = true;
$jsonResponse = json_encode($response);
echo($jsonResponse);

?>