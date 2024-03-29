<?php

/*******************************************************************************
 * Used to upload a staff member onto the list of authenticated users
 * 
 * JS: addStaff.js
 ******************************************************************************/

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'authentication';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Don't really want to try and grab a variable that doesn't exist
if (!isset($_REQUEST['name'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['pin'], $_REQUEST['hasAdmin'])) {
	header("Location: ../index.html");
	exit();
}

$name     = $_REQUEST['name'];
$username = $_REQUEST['username'];
$password = password_hash($_REQUEST['password'], PASSWORD_ARGON2I);
$pin      = password_hash($_REQUEST['pin'], PASSWORD_ARGON2I);
$hasAdmin = $_REQUEST['hasAdmin'];

// Checks for the provided username within the SQL database
$query = "SELECT username FROM users WHERE username = '" . $username . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
  die ("could not execute statement $query<br />");
}

// Need to make sure that the given username does not already exist within the 
// database
if (mysqli_num_rows($check) != 0) {
	$response[0] = false;
  $response[1] = "This username already exists";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

// Now that we know the username does not exist, we are able to enter it into
// the SQL database
$query = "INSERT INTO users (name, username, password, pin, admin) VALUES ('" . $name . "', '" . $username . "', '" . $password . "', '" . $pin . "', '" . $hasAdmin . "')";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
  die ("could not execute statement $query<br />");
}

$response[0] = true;
$jsonResponse = json_encode($response);
echo($jsonResponse);

?>