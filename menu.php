<?php
session_start();
if(!isset($_SESSION["user"]) || strcmp($_SESSION["idtype"], 'admin')==0) { //session variable not set or wrong session type
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
  
  $ID = $_POST["Venue_ID"];

  $sql = "SELECT Dietary_Accomodations, Name, Price, Type FROM serves NATURAL JOIN Menu_Item WHERE Venue_ID = '$ID'";

  if (mysqli_query($con, $sql))
  {

    //echo "Searched";

    $results  = mysqli_query($con,$sql);
    //echo mysqli_fetch_assoc($results);
    echo "
    <h1>" . $user .",  </h1>
    <form action=\"favorite.php\" class=\"unstyled\">
    <input type=\"submit\" value=\"View Your Favorites\" class=\"submit\"/>
    </form>
    <h2>Search Results</h2>
    <table>
    <tr>
    <th>Name</th>
    <th>Price</th>
    <th>Entree Type</th>
    <th>Dietary Accomodations</th>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    </tr>";
    while ($row  = mysqli_fetch_assoc($results)) {
      $name = $row['Name'];
      $price = $row['Price'];
      $type = $row['Type'];
      $diet = $row['Dietary_Accomodations'];
      // echo '<pre>';
      // print_r($row);
      // echo '</pre>';

      echo "
      <tr>
      <td width=\"10%\"><center> $name </center></td>
      <td width=\"10%\"><center> $price </center></td>
      <td width=\"10%\"><center> $type </center></td>
      <td width=\"10%\"><center> $diet </center></td>
      </tr>

      <tr>
      <td> &nbsp; </td>
      <center>
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
