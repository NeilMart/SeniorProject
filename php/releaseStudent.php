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

// Don't really want to try and grab a variable that doesn't exist, or in this 
// case, several of them
if (!isset($_SESSION["name"], $_SESSION["id"], $_REQUEST["pin"], $_REQUEST["time"], $_REQUEST["destination"])) {
  header('Location: ../index.html');
	exit();
}

$name        = $_SESSION["name"];
$id          = $_SESSION["id"];
$pin         = $_REQUEST["pin"];
$time        = $_REQUEST["time"];
$destination = $_REQUEST["destination"];

// Goes into the database and finds the PIN associated with the currently signed
// in account
$query = "SELECT pin FROM users WHERE username = '" . $name . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$databasePIN = $check->fetch_array(MYSQLI_NUM);

// The code should only move forward if the teacher has provided the correct PIN
if (password_verify($pin, $databasePIN[0])) {
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'root';
  $DATABASE_PASS = 'TiwIsamd8ta.';
  $DATABASE_NAME = 'studentlist';

  $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  if ( mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
  }

  // Find the student's hallmonitor template and fill out the rest of the fields
  // with the now provided data, creating a full-fledged check out entry
  $query = "UPDATE hallmonitor SET destination = '" . $destination . "', timeout = '" . $time . "' WHERE id = '" . $id . "'";
  $check = mysqli_query($conn, $query);

  if ($check == FALSE) { 
    die("could not execute statement $query<br />");
  }

  $response[0] = true;
  $encodedResponse = json_encode($response);
  echo($encodedResponse);
} else { // The PIN was wrong
  $response[0] = false;
  $response[1] = "Incorrect PIN provided";
  $encodedResponse = json_encode($response);
  echo($encodedResponse);
}
?>