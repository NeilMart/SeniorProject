<?php

/*******************************************************************************
 * Used by the student to officially check out of a classroom, provided the
 * teacher has provided the correct PIN
 * 
 * JS: location.js
 ******************************************************************************/

session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'authentication';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$conn2 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, 'studentlist');
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Don't really want to try and grab a variable that doesn't exist, or in this 
// case, several of them
if (!isset($_SESSION["name"], $_REQUEST["pin"], $_REQUEST["id"])) {
  header('Location: ../index.html');
	exit();
}

$origin = $_SESSION["name"];
$pin    = $_REQUEST["pin"];
$id     = $_REQUEST["id"];

// Goes into the database and finds the PIN associated with the currently signed
// in account
$query = "SELECT pin FROM users WHERE username = '" . $origin . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$databasePIN = $check->fetch_array(MYSQLI_NUM);

// The code should only move forward if the teacher has provided the correct PIN
if (password_verify($pin, $databasePIN[0])) {
  $query = "SELECT name FROM users WHERE username = '" . $origin . "'";
  $check = mysqli_query($conn, $query);

  if ($check == FALSE) { 
    die("could not execute statement $query<br />");
  }

  $originName = $check->fetch_array(MYSQLI_NUM);
  $name = $originName[0];

  $query = "INSERT INTO hallmonitor (id, origin, destination, timeout) VALUES ('" . $id . "', '" . $name . "', '" . "TBD" . "', '" . 0000 . "')";
	$check = mysqli_query($conn2, $query);

	if ($check == FALSE) { 
		die("could not execute statement $query<br />");
	}

	// I will need this on another page of the website, so it is stored in the
	// session
	$_SESSION["id"] = $id;
	$response[0] = true;
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
} else { // The PIN was wrong
  $response[0] = false;
  $response[1] = "Incorrect PIN provided";
  $encodedResponse = json_encode($response);
  echo($encodedResponse);
}
?>