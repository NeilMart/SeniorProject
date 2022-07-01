<?php

/*******************************************************************************
 * Sub-menu that allows an admin to manage the student roster through viewing /
 * updating its contents ... can be done individually or in bulk using CSV
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
      <h1 class="title">Manage Students</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <form>
        <button type="submit" class="full-width" formaction="./viewRoster.php">View Roster</button>
        <button type="submit" class="full-width" formaction="./uploadRoster.php">Update Roster</button>
        <button type="submit" class="full-width" formaction="./addStudent.php">Add Student</button>
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