<?php

/*******************************************************************************
 * Used to remove anyone that exited the queue using a non "happy path" ... ran
 * everytime the login homepage is loaded
 * 
 * JS: checkIO.js
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

$conn2 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, 'authentication');
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_SESSION['name'])) {
	header('Location: ../index.html');
	exit();
}

$origin = $_SESSION['name'];

$query = "SELECT name FROM users WHERE username = '" . $origin . "'";
$check = mysqli_query($conn2, $query);
$originName = $check->fetch_array(MYSQLI_NUM);
$name = $originName[0];

$query = "DELETE FROM hallmonitor WHERE destination = '" . "TBD" . "' AND origin = '" . $name . "'";
$check = mysqli_query($conn, $query);

if (isset($_SESSION["id"])) {
  unset($_SESSION["id"]);
}
?>