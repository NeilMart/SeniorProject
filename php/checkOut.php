<?php

/*******************************************************************************
 * Connected to the login homepage, allows students to sign out assuming that 
 * they exist and also have not yet signed out 
 *
 * JS: checkIO.js
*******************************************************************************/

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

// Don't really want to try and grab a variable that doesn't exist
if (!isset($_REQUEST['id'], $_SESSION['name'])) {
	header('Location: ../index.html');
	exit();
}

$id     = $_REQUEST['id'];
$origin = $_SESSION['name'];

// My PHP session only stores the username, which is sometimes less useful to me
// than the actual name it is associated with... this grabs that name from the
// database
$query = "SELECT name FROM users WHERE username = '" . $origin . "'";
$check = mysqli_query($conn2, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

$originName = $check->fetch_array(MYSQLI_NUM);
$name = $originName[0];

// I need to see if this ID is already associated with an ID that is out in the
// halls
$query = "SELECT origin FROM hallmonitor WHERE id = '" . $id . "'";
$check = mysqli_query($conn, $query);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

// If I get any kind of response, we have officially entered schenanigan
// territory... probably
if (mysqli_num_rows($check) != 0) {
	$response[0] = false;
  $response[1] = "You've already checked out...";
	$response[2] = false;
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}

// Use the ID of student 1 to find all of its associations, checking whether
// a forbidden student has already checked out
$stmt = "SELECT Student2 FROM restrictions WHERE Student1 = '" . $id . "' ";
$result = mysqli_query($conn, $stmt);

if ($result == FALSE) { 
  die ("could not execute statement $stmt<br />");
}

// Find out who is currently in the hall
$stmt = "SELECT id FROM hallmonitor";
$hall = mysqli_query($conn, $stmt);

if ($hall == FALSE) { 
  die ("could not execute statement $stmt<br />");
}

// Load the hall into an array
$studentsInHall = array();
while ($row = $hall->fetch_row()) {
  array_push($studentsInHall, $row[0]);
}


if (mysqli_num_rows($result) != 0) {
  while ($row = $result->fetch_row()) {
		foreach($studentsInHall as &$value) {
			if ($row[0] == $value) {
				$response[0] = false;
				$response[1] = "The halls are full";
				$response[2] = true;
				$jsonResponse = json_encode($response);
				echo($jsonResponse);
				exit();
			}
    }

		// Have to free up this memory for each iteration of the loop
		unset($value);
  }
}

// Do the same as above but in reverse, just to be extra careful with it
$stmt = "SELECT Student1 FROM restrictions WHERE Student2 = '" . $id . "' ";
$result = mysqli_query($conn, $stmt);

if ($result == FALSE) { 
  die ("could not execute statement $stmt<br />");
}

if (mysqli_num_rows($result) != 0) {
  while ($row = $result->fetch_row()) {
		foreach($studentsInHall as &$value) {
			if ($row[0] == $value) {
				$response[0] = false;
				$response[1] = "The halls are full";
				$response[2] = true;
				$jsonResponse = json_encode($response);
				echo($jsonResponse);
				exit();
			}
    }

		// Have to free up this memory for each iteration of the loop
		unset($value);
  }
}

// Uses the student's ID to grab their name
$query = "SELECT name FROM student WHERE id = '" . $id . "'";

// Returns every row current within the hallmonitor
$blanketQuery = "SELECT * FROM hallmonitor";

$check = mysqli_query($conn, $query);
$total = mysqli_query($conn, $blanketQuery);

if ($check == FALSE) { 
	die("could not execute statement $query<br />");
}

if ($total == FALSE) { 
	die("could not execute statement $blanketQuery<br />");
}

// If no name is associated with the given ID, the student must not exist
if (mysqli_num_rows($check) == 0) {
	$response[0] = false;
  $response[1] = "No student with that ID was found";
	$response[2] = false;
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
} 

// The student exists, but they can only be released if there are fewer than ten
// students in the halls at this point in time
else if (mysqli_num_rows($total) < 10) {

	// Create a template for the student in the hallmonitor, allowing them to
	// reserve their spot while they choose their destination
	$query = "INSERT INTO hallmonitor (id, origin, destination, timeout) VALUES ('" . $id . "', '" . $name . "', '" . "TBD" . "', '" . 0000 . "')";
	$check = mysqli_query($conn, $query);

	if ($check == FALSE) { 
		die("could not execute statement $query<br />");
	}

	// I will need this on another page of the website, so it is stored in the
	// session
	$_SESSION["id"] = $id;
	$response[0] = true;
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
} else { // There are already ten students in the hallway
	$response[0] = false;
  $response[1] = "The halls are full";
	$response[2] = true;
	$jsonResponse = json_encode($response);
	echo($jsonResponse);
  exit();
}
?>