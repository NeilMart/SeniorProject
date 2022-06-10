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
      <a class="return" href="javascript:history.back()"><img src="../images/icons8-back-arrow-50.png" alt="Back Arrow"></a>
      <h1 class="title">Add Student</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <div id="error-message-top" class="error-message">
        <p id="error-text-top" class="error-text"></p>
      </div>
      <form id="student-form">
        <input type="text" name="student-name" id="student-name" placeholder="Full Name" class="full-width" required>
        <div class="error-message" id="error-message">
          <p id="error" class="error-text"></p>
        </div>
        <input type="text" name="student-id" id="student-id" placeholder="Student ID" class="full-width" required>
        <input type="submit" value="Add Student" id="submit" class="full-width">
      </form>
    </main>
    <footer class="footer">@Produced in 2022</footer>
    <script type="module" src="../js/addStudent.js"></script>
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>