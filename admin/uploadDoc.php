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
      <a class="return" href="./register.php"><img src="../images/icons8-back-arrow-50.png" alt="Back Arrow"></a>
      <h1 class="title">Upload</h1>
      <a class="signout" href="../index.html">Signout</a>
    </header>
    <main>
      <form action="../php/largeUpload.php" method="POST" enctype="multipart/form-data">
        <input type="file" class="full-width" id="customFileInput" aria-describedby="customFileInput" name="file">
        <input type="submit" name="submit" value="Upload" class="full-width">
      </form>
    </main>
    <footer class="footer">@Produced in 2022</footer>
    <script type="module" src="../js/main.js"></script>
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>