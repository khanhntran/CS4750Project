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
  <title>Dietary Restrictions</title>
  <link rel = "stylesheet" type = "text/css" href = "style.css"/>
</head>
<body>
  <?php
  include_once('./library.php');
  $con = mysqli_connect($SERVER, $USERNAME, $PASSWORD, $DATABASE);
  if (mysqli_connect_errno()) {
    echo("Can't connect to MySQL Server. Error code: " .
    mysqli_connect_error());
  }

  $gf = "SELECT DISTINCT Name FROM gluten WHERE Dietary_Accomodations = 'Gluten Free'";
  $vegan = "SELECT DISTINCT Name FROM vegan WHERE Dietary_Accomodations = 'Vegan'";
  $veggie = "SELECT DISTINCT Name FROM veggie WHERE Dietary_Accomodations = 'Vegetarian'";

    echo "
    <h1>" . $user .", <br> Below are venues in Charlottesville that cater to dietary restrictions </h1><br>";


    $result1 = mysqli_query($con, $gf);
    echo "
    <table>
    <tr>
    <th>Venues With Gluten Free Items</th>
    </tr>";
    while ($row = mysqli_fetch_assoc($result1)) {
      $name = $row["Name"];
      echo "
      <tr>
      <td width=\"10%\"><center> $name </center></td>";
    }
    echo "
    </table>
    <br><br>";

    $result2 = mysqli_query($con, $vegan);
    echo "
    <table>
    <tr>
    <th>Venues With Vegan Items</th>
    </tr>";
    while ($row = mysqli_fetch_assoc($result2)) {
      $name = $row["Name"];
      echo "
      <tr>
      <td width=\"10%\"><center> $name </center></td>";
    }
    echo "
    </table>
    <br><br>";

    $result3 = mysqli_query($con, $veggie);
    echo "
    <table>
    <tr>
    <th>Venues With Vegetarian Items</th>
    </tr>";
    while ($row = mysqli_fetch_assoc($result3)) {
      $name = $row["Name"];
      echo "
      <tr>
      <td width=\"10%\"><center> $name </center></td>";
    }
    echo "
    </table>
    <br><br>";

    echo "
    </table>
    <br>
    <form action=\"searchPage.php\" class=\"unstyled\">
    <input type=\"submit\" value=\"Go Back to Search Page\" class=\"submit\"/>
    </form>
    <form action=\"Logout.php\" class=\"unstyled\">
    <input type=\"submit\" value=\"Logout\" class=\"logout\"/>
    </form>";


  mysqli_close($con);

  ?>
</body>
</html>