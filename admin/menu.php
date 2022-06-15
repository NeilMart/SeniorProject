<?php
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
      <h1 class="title">Menu</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <form>
        <button type="submit" class="full-width" formaction="./viewRoster.php">View Roster</button>
        <button type="submit" class="full-width" formaction="./addRemove.php">Add/Remove Students</button>
        <button type="submit" class="full-width" formaction="">Add/Remove Staff</button>
        <button type="submit" class="full-width" formaction="">Parameters</button>
      </form>
    </main>
    <footer class="footer">@Produced in 2022</footer>
    <!-- <script type="module" src="../js/main.js"></script> -->
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>
