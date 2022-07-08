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
      <h1 class="title">Student Permissions</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <form>
        <button type="submit" class="full-width" formaction="viewPermissions.php">View Existing</button>
        <button type="submit" class="full-width" formaction="addNewPermission.php">Add New</button>
      </form>
    </main>
    <footer class="footer">@Produced in 2022</footer>
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>
