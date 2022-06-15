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
    <template id="teacher-option">
      <option id="target-option"></option>
    </template>
    <header class="title-bar">
      <a class="return" href="javascript:history.back()"><img src="../images/icons8-back-arrow-50.png" alt="Back Arrow"></a>
      <h1 class="title">Location</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <p id="stu-name" class="stu-name"></p>
      <p id="stu-generic" class="stu-generic">is requesting permission to check out to the:</p>
      <form id="page-form">
        <select id="location" class="full-width">
          <option value="bathroom">Bathroom</option>
          <option value="teacher">Teacher</option>
          <option value="library">Library</option>
          <option value="office">Office</option>
        </select>
        <select id="teachers" class="full-width"></select>
        <input type="password" name="pin" id="pin" class="full-width" placeholder="Teacher PIN" required>
        <input type="submit" id="approve" value="Approve" name="approve"> 
        <input type="submit" id="deny" value="Deny" name="deny" formnovalidate>
      </form>
    </main>
    <footer class="footer">@Produced in 2022</footer>
    <script type="module" src="../js/location.js"></script>
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>