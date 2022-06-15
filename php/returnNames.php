<?php
  $servername='localhost';
  $username='root';
  $password='TiwIsamd8ta.';
  $dbname = "authentication";
  $db = mysqli_connect($servername,$username,$password,"$dbname");

  if(!$db) {
    die('Could not Connect MySql Server:' .mysql_error());
  }

  $stmt = "SELECT name FROM users";
  $result = mysqli_query($db, $stmt);
  
  if ($result == FALSE) { 
    die ("could not execute statement $stmt<br />");
  }

  $output = array();
  while ($row = $result->fetch_row()) {
    array_push($output, $row);
  }

  $enocdedOutput = json_encode($output);
  echo($enocdedOutput);
?>