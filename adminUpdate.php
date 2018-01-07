<?php
session_start();
if(!isset($_SESSION["user"]) || strcmp($_SESSION["idtype"], 'user')==0) { //session variable not set or wrong session type
  header("Location:Logout.php"); //redirect if not logged in
}
$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
  <link rel = "stylesheet" type = "text/css" href = "style.css"/>
</head>
<body>
  <?php
  include_once("./library.php"); // To connect to the database
  $con = mysqli_connect($SERVER, $USERNAME, $PASSWORD, $DATABASE);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  // Form the SQL query (an INSERT query)
  $sql = "SELECT Venue_ID, Name, Address, Hours, Phone_Number, Description FROM Venue ORDER BY Name";

  //  echo $sql;


  if (mysqli_query($con, $sql))
  {

    $results  = mysqli_query($con,$sql);
    echo "
    <h1>" . $user .",  </h1>
    <h2><a href='adminPage.php'>Insert New Venue</a></h2>
    <h3>Venues</h3>
    <table>
    <tr>
    <th>Name</th>
    <th>Address</th>
    <th>Phone Number</th>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    </tr>";
    while ($row  = mysqli_fetch_assoc($results)) {
      $name = $row['Name'];
      $address = $row['Address'];
      $phone = $row['Phone_Number'];
      $desc = $row['Description'];
      $ID = $row['Venue_ID'];

      // echo '<pre>';
      // print_r($row);
      // echo '</pre>';

      echo "
      <tr>
      <td width=\"10%\"><center> $name </center></td>
      <td width=\"70%\"><center> $address </center></td>
      <td width=\"10%\"><center> $phone </center></td>
      <td width=\"10%\"><center> 
          <form action = 'editVenue.php' method = 'POST'>
             <input type = 'submit' name = 'submit' value = 'Edit' class = 'submit'/>
             <input type = 'hidden' name = 'Venue_ID' value = $ID/>
          </form>
      </td>
      </tr>

      <tr>
      <td> &nbsp; </td>
      <center>
      <td><b>Description:</b> $desc </td>
      <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
      </center>
      </tr>";

    }

    echo "
    </table>
    <br><br>
    <form action=\"searchPage.php\" class=\"unstyled\">
    <input type=\"submit\" value=\"Go Back to Search Page\" class=\"submit\"/>
    </form>
    <form action=\"Logout.php\" class=\"unstyled\">
    <input type=\"submit\" value=\"Logout\" class=\"logout\"/>
    </form>";




  }
  else
  {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
  }

  mysqli_close($con);
  ?>

</body>
</html>
