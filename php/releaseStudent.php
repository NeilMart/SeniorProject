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

if (!isset($_SESSION["name"]) || !isset($_REQUEST["pin"])) {
  $response[0] = false;
  $response[1] = "Redirect";
  $encodedResponse = json_encode($response);
  echo($encodedResponse);
  exit("something wasn't set right");
}

$name        = $_SESSION["name"];
$id          = $_SESSION["id"];
$pin         = $_REQUEST["pin"];
$time        = $_REQUEST["time"];
$destination = $_REQUEST["destination"];

$query = "SELECT pin FROM users WHERE username = '" . $name . "'";
$check = mysqli_query($conn, $query);
$databasePIN = $check->fetch_array(MYSQLI_NUM);

if ($pin == $databasePIN[0]) {
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'root';
  $DATABASE_PASS = 'TiwIsamd8ta.';
  $DATABASE_NAME = 'studentlist';

  $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  if ( mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
  }

  $query = "UPDATE hallmonitor SET destination = '" . $destination . "', timeout = '" . $time . "' WHERE id = '" . $id . "'";
  $check = mysqli_query($conn, $query);

  $response[0] = true;
  $encodedResponse = json_encode($response);
  echo($encodedResponse);
} else {
  $response[0] = false;
  $response[1] = "Incorrect PIN provided";
  $encodedResponse = json_encode($response);
  echo($encodedResponse);
}
?>