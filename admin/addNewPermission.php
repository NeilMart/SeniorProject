<?php

/*******************************************************************************
 * Navigational menu for student permissions
 ******************************************************************************/

session_start();
if (isset($_SESSION['loggedin'])) {
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Senior Project</title>
    <link rel="stylesheet" href="../css/style.css"/>
  </head>
  <body>
    <header class="title-bar">
      <a class="return" href="javascript:history.back()"><img src="../images/icons8-back-arrow-50.png" alt="Back Arrow"></a>
      <h1 class="title">Add New Permission</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <div id="error-message-top" class="error-message">
        <p id="error-text-top" class="error-text"></p>
      </div>
      <form id="student-form">
        <div class="error-message" id="error-message">
          <p id="error" class="error-text"></p>
        </div>
        <input type="text" name="stuID1" id="stuID1" placeholder="ID 1" class="full-width" required>
        <div class="error-message" id="error-message-2">
          <p id="error-2" class="error-text"></p>
        </div>
        <input type="text" name="stuID2" id="stuID2" placeholder="ID 2" class="full-width" required>
        <input type="submit" value="Create Restriction" id="submit" class="full-width">
      </form>
    </main>
    <footer class="footer">@Produced in 2022</footer>
    <script type="module" src="../js/newPermission.js"></script>
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>
