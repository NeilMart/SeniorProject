<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'studentlist';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$query = "DELETE FROM hallmonitor WHERE destination = '" . "TBD" . "'";
$check = mysqli_query($conn, $query);

if (isset($_SESSION["id"])) {
  unset($_SESSION["id"]);
}
?>