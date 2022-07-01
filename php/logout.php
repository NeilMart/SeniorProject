<?php

/*******************************************************************************
 * Mostly used to protect the program from intrusion ... disables the session
 * once the page is closed
 ******************************************************************************/

session_start();

if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
  );
}

if (isset($_SESSION['loggedin'])) {
  session_destroy();
}
?>