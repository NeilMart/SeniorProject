<?php

/*******************************************************************************
 * Allows an admin to view the hallmonitor, which is a frequently updating list
 * of where students left from and where they are going
 * 
 * JS: viewHallway.js
 ******************************************************************************/

session_start();
if (isset($_SESSION['loggedin'])) {
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="refresh" content="30">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Senior Project</title>
    <link rel="stylesheet" href="../css/style.css"/>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  </head>
  <body>
    <header class="sticky-title-bar">
      <a class="return" href="javascript:history.back()"><img src="../images/icons8-back-arrow-50.png" alt="Back Arrow"></a>
      <h1 class="title">Hall Monitor</h1>
      <a class="signout" href="../index.html"><button class="so-button">Sign Out</button></a>
    </header>
    <main>
      <div class="table-container">
        <table class="styled-table">
          <thead>
            <tr>
              <th>Name
              <th>Origin
              <th>Destination
              <th>Away Time
            </tr>
          </thead>
          <tbody>
            <?php

            /*******************************************************************
             * Dynamically connects to the SQL Hallmonitor and displays the
             * information in an HTML table
             ******************************************************************/

              $DATABASE_HOST = 'localhost';
              $DATABASE_USER = 'root';
              $DATABASE_PASS = 'TiwIsamd8ta.';
              $DATABASE_NAME = 'studentlist';
              
              $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
              if (mysqli_connect_errno()) {
                exit('Failed to connect to MySQL: ' . mysqli_connect_error());
              }

              // Generate a list of students ordered by the amount of time that
              // they've been checked out ... don't show students who are still
              // navigating the menus
              $stmt = "SELECT * FROM hallmonitor WHERE destination != '" . "TBD" . "' ORDER BY timeout";
              $result = mysqli_query($conn, $stmt);

              if ($result == FALSE) { 
                die ("could not execute statement $stmt<br />");
              }

              // Fetch results from the query one row at a time, using them to
              // populate the rows of the HTML table
              while ($row = $result->fetch_row()) {

                // I don't want to show a list of IDs, so I use the ID data to
                // grab the student's names
                $stmt   = "SELECT name FROM student WHERE id = '" . $row[0] ."'";
                $output = mysqli_query($conn, $stmt);
                $results = $output->fetch_array(MYSQLI_NUM);

                // I have to generate an empty cell that contains the actual
                // time data at checkout ... I then use this cell to generate
                // data that is actually displayed, which is time since checkout
                print "<tr>\n";
                print "  <td>" . $results[0] . "\n";            // name
                print "  <td>" . $row[1] . "\n";                // origin
                print "  <td>" . $row[2] . "\n";                // destination
                print "  <td id='time' class='time'> \n";       // time out
                print "  <td class='noshow'>" . $row[3] . "\n"; // non-visible
                print "</tr>\n";
              }
            ?>

          </tbody>
        </table>
      </div>
    </main>
    <footer class="footer">@Produced in 2022</footer>
    <script type="module" src="../js/viewHallway.js"></script>
  </body>
</html>

<?php
} else {
  header('location: ../error/error403.html');
}
?>
