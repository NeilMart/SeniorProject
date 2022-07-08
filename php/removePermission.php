<?php

/*******************************************************************************
 * Used to remove students from the application roster
 * 
 * JS: viewPermissions.js
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
if (!isset($_REQUEST['name1'], $_REQUEST['name2'])) {
	header('Location: ../index.html');
	exit();
}

$name1 = $_REQUEST['name1'];
$name2 = $_REQUEST['name2'];

// This uses the student's name to grab their ID from the database
$query = "SELECT id FROM student WHERE name = '" . $name1 . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$results = $check->fetch_array(MYSQLI_NUM);

// This uses the 2nd student's name to grab their ID from the database
$query = "SELECT id FROM student WHERE name = '" . $name2 . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$results2 = $check->fetch_array(MYSQLI_NUM);

// Now that I have both IDs, I can remove them from the list
$query = "DELETE FROM restrictions WHERE Student1 = '" . $results[0] . "' AND Student2 = '" . $results2[0] . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$response[0] = true;
$jsonResponse = json_encode($response);
echo($jsonResponse);

?>