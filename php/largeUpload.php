<?php

/*******************************************************************************
 * Used to upload an entire CSV file representing the student roster
 * 
 * JS: studentUpload.js
 ******************************************************************************/

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'studentlist';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (isset($_REQUEST['submit'])) {
  $fileMimes = array(
      'text/x-comma-separated-values',
      'text/comma-separated-values',
      'application/octet-stream',
      'application/vnd.ms-excel',
      'application/x-csv',
      'text/x-csv',
      'text/csv',
      'application/csv',
      'application/excel',
      'application/vnd.msexcel',
      'text/plain'
  );

  if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes)) {
    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
    fgetcsv($csvFile);

    mysqli_query($conn, 'TRUNCATE TABLE student;');
    while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
      $name = $getData[0];
      $id =   $getData[1];

      $query = "SELECT name FROM student WHERE id = '" . $getData[1] . "'";
      $check = mysqli_query($conn, $query);

      if ($check == FALSE) { 
        die("could not execute statement $query<br />");
      }

      mysqli_query($conn, "INSERT INTO student (name, id) VALUES ('" . $name . "', '" . $id . "')");
    }

    fclose($csvFile);
    
    $response[0] = true;
    $jsonResponse = json_encode($response);
		echo($jsonResponse);

    // Now I need to iterate through all of the restrictions, making sure that
    // they're all still valid
    $query = "SELECT Student1 FROM restrictions";
    $check = mysqli_query($conn, $query);

    if ($check == FALSE) { 
      die("could not execute statement $query<br />");
    }

    if (mysqli_num_rows($check) != 0) {
      while ($row = $check->fetch_row()) {
        $query = "SELECT id FROM student WHERE id = '" . $row[0] . "'";
        $possibleResponse = mysqli_query($conn, $query);

        if ($possibleResponse == FALSE) { 
          die("could not execute statement $query<br />");
        }

        // If the student no longer exists, I remove their entry from the
        // student restrictions table
        if (mysqli_num_rows($possibleResponse) == 0) {
          $query = "DELETE FROM restrictions WHERE Student1 = '" . $row[0] . "'";
          $removeEntries = mysqli_query($conn, $query);

          if ($removeEntries == FALSE) { 
            die("could not execute statement $query<br />");
          }
        }
      }
    }

    // I need to now iterate through the 2nd row of restrictions
    $query = "SELECT Student2 FROM restrictions";
    $check = mysqli_query($conn, $query);

    if ($check == FALSE) { 
      die("could not execute statement $query<br />");
    }

    if (mysqli_num_rows($check) != 0) {
      while ($row = $check->fetch_row()) {
        $query = "SELECT id FROM student WHERE id = '" . $row[0] . "'";
        $possibleResponse = mysqli_query($conn, $query);

        if ($possibleResponse == FALSE) { 
          die("could not execute statement $query<br />");
        }

        // If the student no longer exists, I remove their entry from the
        // student restrictions table
        if (mysqli_num_rows($possibleResponse) == 0) {
          $query = "DELETE FROM restrictions WHERE Student2 = '" . $row[0] . "'";
          $removeEntries = mysqli_query($conn, $query);

          if ($removeEntries == FALSE) { 
            die("could not execute statement $query<br />");
          }
        }
      }
    }
  } else {
    $response[0] = false;
		$jsonResponse = json_encode($response);
		echo($jsonResponse);
  }
}