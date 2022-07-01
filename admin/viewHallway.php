<!-- Allows an admin to view the hallmonitor, which is a frequently updating 
list of where students left from and where they are going -->

<?php
session_start();
if (isset($_SESSION['loggedin'])) {
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="refresh" content="60">
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
              <th>Time Out
            </tr>
          </thead>
          <tbody>

            <?php
              $servername='localhost';
              $username='root';
              $password='TiwIsamd8ta.';
              $dbname = "studentlist";
              $db = mysqli_connect($servername,$username,$password,"$dbname");

              if(!$db) {
                die('Could not Connect MySql Server:' .mysql_error());
              }

              $stmt = "SELECT * FROM hallmonitor";
              $result = mysqli_query($db, $stmt);

              if ($result == FALSE) { 
                die ("could not execute statement $stmt<br />");
              }

              while ($row = $result->fetch_row()) {
                $stmt   = "SELECT name FROM student WHERE id = '" . $row[0] ."'";
                $output = mysqli_query($db, $stmt);
                $results = $output->fetch_array(MYSQLI_NUM);

                print "<tr>\n";
                print "  <td>" . $results[0] . "\n"; // name
                print "  <td>" . $row[1] . "\n";     // origin
                print "  <td>" . $row[2] . "\n";     // destination
                print "  <td id='time' class='time'> \n";         // time out
                print "  <td class='noshow'>" . $row[3] . "\n";
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
