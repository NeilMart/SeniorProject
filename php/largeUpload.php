<?php
$servername='localhost';
$username='root';
$password='TiwIsamd8ta.';
$dbname = "studentlist";
$conn=mysqli_connect($servername,$username,$password,"$dbname");

$success = false;

if(!$conn) {
  die('Could not Connect MySql Server:' .mysql_error());
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

      mysqli_query($conn, "INSERT INTO student (name, id) VALUES ('" . $name . "', '" . $id . "')");
    }

    fclose($csvFile);
    $success = true;
    
    $response[0] = $success;
    $jsonResponse = json_encode($response);
		echo($jsonResponse);
  } else {
    $response[0] = $success;
		$jsonResponse = json_encode($response);
		echo($jsonResponse);
  }
}