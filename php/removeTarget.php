<?php

/*******************************************************************************
 * Used to remove students from the application roster
 * 
 * JS: viewRoster.js
 ******************************************************************************/

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'studentlist';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Don't really want to try and grab a variable that doesn't exist
if (!isset($_REQUEST['id'])) {
	header('Location: ../index.html');
	exit();
}

$id = $_REQUEST['id'];

// This uses the student's ID to grab their name from the database
$query = "SELECT name FROM student WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

// If nothing is returned using the ID, the student must not exist
if (mysqli_num_rows($check) == 0) {
	$response[0] = false;
  $response[1] = "No student with that ID was found";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

// Now that I know that the student exists, I can make them not exist
$query = "DELETE FROM student WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$response[0] = true;
$jsonResponse = json_encode($response);
echo($jsonResponse);

?>