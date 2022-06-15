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

if (!isset($_SESSION["id"])) {
  $response[0] = false;
  $encodedResponse = json_encode($response);
  echo($encodedResponse);
  exit();
}

$id = $_SESSION["id"];
$query = "SELECT name FROM student WHERE id = $id";
$check = mysqli_query($conn, $query);
$results = $check->fetch_array(MYSQLI_NUM);

$response[0] = true;
$response[1] = $results[0];
$encodedResponse = json_encode($response);
echo($encodedResponse);

?>