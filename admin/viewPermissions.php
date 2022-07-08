<?php

/*******************************************************************************
 * Allows an admin to view the entire student roster at once, also providing the
 * ability to individually remove students
 * 
 * JS: viewPermissions.js
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
      <h1 class="title">View Permissions</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <div class="table-container">
        <table class="styled-table">
          <thead>
            <tr>
              <th>Name 1
              <th>Name 2
              <th>Delete
            </tr>
          </thead>
          <tbody>
            <?php

              /*****************************************************************
               * Dynamically connects to the SQL permission database and uses 
               * the information to populate an HTML table
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
              $stmt = "Select * from restrictions ORDER BY Student1";
              $result = mysqli_query($conn, $stmt);
              
              if ($result == FALSE) { 
                die("could not execute statement $stmt<br />");
              }

              // Go through the results one at a time, using them to populate
              // the table
              while ($row = $result->fetch_row()) {

                // Use the 1st ID to find the 1st student's name
                $stmt = "SELECT name FROM student WHERE id = '" . $row[0] . "'";
                $results = mysqli_query($conn, $stmt);

                if ($results == FALSE) { 
                  die ("could not execute statement $stmt<br />");
                }

                $check = $results->fetch_array(MYSQLI_NUM);

                // Use the 2nd ID to find the 2nd student's name
                $stmt = "SELECT name FROM student WHERE id = '" . $row[1] . "'";
                $results = mysqli_query($conn, $stmt);

                if ($results == FALSE) { 
                  die ("could not execute statement $stmt<br />");
                }

                $check2 = $results->fetch_array(MYSQLI_NUM);

                print "<tr>\n";
                print "  <td>" . $check[0] . "\n";  // name 1
                print "  <td>" . $check2[0] . "\n"; // name 2

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
    <script type="module" src="../js/viewPermissions.js"></script>
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>
