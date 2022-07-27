<?php

/*******************************************************************************
 * The entry point of the application, where the users are able to login
 * 
 * JS: login.js
 ******************************************************************************/
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'TiwIsamd8ta.';
$DATABASE_NAME = 'authentication';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['destination'])) {
	header('Location: ../index.html');
	exit();
}

if ($stmt = $conn->prepare('SELECT username, password FROM users WHERE username = ?')) {
	$stmt->bind_param('s', $_REQUEST['username']);
	$stmt->execute();
	$stmt->store_result();

	// Only move forward if the username actually exists
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($username, $hashpassword);
		$stmt->fetch();
		
		// We know the username exists, but does the password match?
		if (password_verify($_REQUEST['password'], $hashpassword)) {

			// I use the now existant username to see what this user's permissions are
			$destination = $_REQUEST['destination'];
			$query = "SELECT admin FROM users WHERE username = '" . $username . "'";
			$check = mysqli_query($conn, $query);

			if ($check == FALSE) { 
				die("could not execute statement $query<br />");
			}

			// Store the user's permissions
			$userRights = $check->fetch_array(MYSQLI_NUM);

			// They want to go to the admin portion of the website - so we better 
			// check whether or not they're allowed
			if ($destination == "admin") {
				if ($userRights[0] == "1") {
					session_start();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['admin'] = TRUE;
					$_SESSION['name'] = $username;

					$response[0] = "./admin/menu.php";
					$response[1] = true;
					$jsonResponse = json_encode($response);
					echo($jsonResponse);
					exit();
				} else { // Guess they weren't allowed
					$response[0] = "You do not have admin privilege";
					$response[1] = false;
					$jsonResponse = json_encode($response);
					echo($jsonResponse);
					exit();
				}
			}

			// The user is trying to access the teacher portion of the application, 
			// and requires no authorization to enter
			session_start();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_REQUEST['username'];

			$response[0] = "./teacher/homepage.php";
			$response[1] = true;
			$jsonResponse = json_encode($response);
			echo($jsonResponse);
		} else { // invalid password
			$response[0] = "Invalid Credentials";
			$response[1] = false;
			$jsonResponse = json_encode($response);
			echo($jsonResponse);
		}
	} else { // invalid username
		$response[0] = "Invalid Credentials";
		$response[1] = false;
		$jsonResponse = json_encode($response);
		echo($jsonResponse);
	}

	$stmt->close();
} else { // This is a slightly different method of something I've been doing
	die("could not execute statement 'SELECT username, password FROM users WHERE username = ?'<br />");
}
?>
