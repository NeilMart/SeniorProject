<?php

/*******************************************************************************
 * Uploads the new JSON permission to the JSON file, if the permission doesn't
 * already exist
 *
 * JS: newPermission.js
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

// Don't really want to try and grab a variable that doesn't exist
if (!isset($_REQUEST['ID1'], $_REQUEST['ID2'])) {
	header('Location: ../index.html');
	exit();
}

$id1 = $_REQUEST['ID1'];
$id2 = $_REQUEST['ID2'];

// Make sure the user doesn't enter two of the same student
if ($id1 == $id2) {
  $response[0] = false;
  $response[1] = "You can't enter the same number twice";
  $jsonResponse = json_encode($response);
  echo($jsonResponse);
  exit();
}

// Checks for the existence of the first student
$stmt = "SELECT id FROM student WHERE id = '" . $id1 . "'";
$result = mysqli_query($conn, $stmt);

if ($result == FALSE) { 
  die ("could not execute statement $stmt<br />");
}

if (mysqli_num_rows($result) == 0) {
  $response[0] = false;
  $response[1] = "At least one of these students does not exist";
  $jsonResponse = json_encode($response);
  echo($jsonResponse);
  exit();
}

// Checks for the existence of the second student
$stmt = "SELECT id FROM student WHERE id = '" . $id2 . "'";
$result = mysqli_query($conn, $stmt);

if ($result == FALSE) { 
  die ("could not execute statement $stmt<br />");
}

if (mysqli_num_rows($result) == 0) {
  $response[0] = false;
  $response[1] = "At least one of these students does not exist";
  $jsonResponse = json_encode($response);
  echo($jsonResponse);
  exit();
}

// Use the ID of student 1 to find all of its associations, checking them
// to see if this new association already exists
$stmt = "SELECT Student2 FROM restrictions WHERE Student1 = '" . $id1 . "' ";
$result = mysqli_query($conn, $stmt);

if ($result == FALSE) { 
  die ("could not execute statement $stmt<br />");
}

if (mysqli_num_rows($result) != 0) {
  while ($row = $result->fetch_row()) {
    if ($row[0] == $id2) {
      $response[0] = false;
      $response[1] = "Permission already exists";
      $jsonResponse = json_encode($response);
      echo($jsonResponse);
      exit();
    }
  }
}

// Do the same as above but in reverse, just to be extra careful with it
$stmt = "SELECT Student2 FROM restrictions WHERE Student1 = '" . $id2 . "' ";
$result = mysqli_query($conn, $stmt);

if ($result == FALSE) { 
  die ("could not execute statement $stmt<br />");
}

if (mysqli_num_rows($result) != 0) {
  while ($row = $result->fetch_row()) {
    if ($row[0] == $id1) {
      $response[0] = false;
      $response[1] = "Permission already exists";
      $jsonResponse = json_encode($response);
      echo($jsonResponse);
      exit();
    }
  }
}

// Now that we know we have two distinct, existent, and non-entered students, we
// are able to add them into the database
$stmt = "INSERT INTO restrictions (Student1, Student2) VALUES ('" . $id1 . "', '" . $id2 . "')";
$result = mysqli_query($conn, $stmt);

if ($result == FALSE) { 
  die ("could not execute statement $stmt<br />");
}

$response[0] = true;
$jsonResponse = json_encode($response);
echo($jsonResponse);