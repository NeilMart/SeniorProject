<?php

/*******************************************************************************
 * Display for the page that allows an admin to upload the entire student roster
 * at once
 * 
 * JS: studentUpload.js
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
      <h1 class="title">Update Roster</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <div id="error-message" class="error-message">
        <p id="error-text" class="error-text"></p>
      </div>
      <form action="../php/largeUpload.php" method="POST" enctype="multipart/form-data" id="upload-form">
        <input type="file" class="full-width" id="customFileInput" aria-describedby="customFileInput" name="file">
        <input type="submit" name="submit" value="Upload" class="full-width">
      </form>
    </main>
    <footer class="footer">@Produced in 2022</footer>
    <script type="module" src="../js/studentUpload.js"></script>
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>