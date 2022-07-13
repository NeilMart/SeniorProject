<?php

/*******************************************************************************
 * Allows an admin to view the entire student roster at once, also providing the
 * ability to individually remove students
 * 
 * JS: viewRoster.js
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
    <header class="sticky-title-bar">
      <a class="return" href="javascript:history.back()"><img src="../images/icons8-back-arrow-50.png" alt="Back Arrow"></a>
      <h1 class="title">View Roster</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <div class="table-container">
        <table class="styled-table">
          <thead>
            <tr>
              <th>Name
              <th>ID
              <th class="delete-header">Delete
            </tr>
          </thead>
          <tbody>
            <?php

              /*****************************************************************
               * Dynamically connects to the SQL student roster and uses the
               * information to populate an HTML table
               ****************************************************************/

              $DATABASE_HOST = 'localhost';
              $DATABASE_USER = 'root';
              $DATABASE_PASS = 'TiwIsamd8ta.';
              $DATABASE_NAME = 'studentlist';
              
              $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
              if (mysqli_connect_errno()) {
                exit('Failed to connect to MySQL: ' . mysqli_connect_error());
              }

              // The student names are listed in alphabetical order
              $stmt = "Select * from student ORDER BY name, id";
              $result = mysqli_query($conn, $stmt);
              
              if ($result == FALSE) { 
                die("could not execute statement $stmt<br />");
              }

              // Go through the results one at a time, using them to populate
              // the table
              while ($row = $result->fetch_row()) {
                print "<tr>\n";
                print "  <td>" . $row[0] . "\n"; // name
                print "  <td>" . $row[1] . "\n"; // id

                // This is a feature that allows the admin to remove a student
                // by clicking on an "x" that is on the far right of their entry
                print "  <td id='remove-entry' class='remove-entry'>" . "X" . "\n";
                print "</tr>\n";
              }
            ?>

          </tbody>
        </table>
      </div>
    </main>
    <footer class="footer">@Produced in 2022</footer>
    <script type="module" src="../js/viewRoster.js"></script>
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>
