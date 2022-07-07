<?php

/*******************************************************************************
 * Used to upload students to the student roster one at a time
 * 
 * JS: addStudent.js
 ******************************************************************************/

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'studentlist';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Don't really want to try and grab a variable that doesn't exist
if (!isset($_REQUEST['name'], $_REQUEST['id'])) {
	echo('Location: ../index.html');
	exit();
}

$name = $_REQUEST['name'];
$id   = $_REQUEST['id'];

// This uses the student's ID to grab their name from the database
$query = "SELECT name FROM student WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
  die ("could not execute statement $query<br />");
}

// A request for this name should not have returned anything - if it did, the 
// student already exists and should not be added again ... having more than one
// of the same ID in this system sounds like a small scale disaster
if (mysqli_num_rows($check) != 0) {
	$response[0] = false;
  $response[1] = "Student already in roster";
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

// Now that we know the student actually doesn't exist, they are added into the
// database
$query = "INSERT INTO student (name, id) VALUES ('" . $name . "', '" . $id . "')";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
  die ("could not execute statement $query<br />");
}

$response[0] = true;
$jsonResponse = json_encode($response);
echo($jsonResponse);

?>