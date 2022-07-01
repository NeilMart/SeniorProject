<?php

/*******************************************************************************
 * The entry point of the application, where the users are able to login
 * 
 * JS: login.js
 ******************************************************************************/

session_start();

$success = FALSE; 

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'authentication';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_REQUEST['username'], $_REQUEST['password'])) {
	header('Location: ../index.html');
	exit();
}

if ($stmt = $conn->prepare('SELECT username, password FROM users WHERE username = ?')) {
	$stmt->bind_param('s', $_REQUEST['username']);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($username, $password);
		$stmt->fetch();
		
		if ($_REQUEST['password'] === $password) {
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_REQUEST['username'];
			$success = TRUE;

			$response[0] = "Invalid Credentials";
			$response[1] = $success;
			$jsonResponse = json_encode($response);
			echo($jsonResponse);
		} else {
			$response[0] = "Invalid Credentials";
			$response[1] = $success;
			$jsonResponse = json_encode($response);
			echo($jsonResponse);
		}
	} else {
		$response[0] = "Invalid Credentials";
		$response[1] = $success;
		$jsonResponse = json_encode($response);
		echo($jsonResponse);
	}

	$stmt->close();
}
?>
