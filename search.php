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
  // Form the SQL query (an INSERT query)
  $sql = "";
  $select = "SELECT Venue_ID, Name, Address, Hours, Phone_Number, Description, Number_of_Favorites";
  $from = " FROM Venue";
  $where = " WHERE 1=1";

  if (!empty($_POST['typeSearch'])) {
    $where .= " AND Cuisine LIKE '%" . addslashes($_POST['typeSearch']) . "%';";
  }

  if (!empty($_POST['venueSearch'])) {
    $where .= " AND Name LIKE '%" . addslashes($_POST['venueSearch']) . "%';";
  }

  $formarr = array("fastfood", "casual", "sitdown", "fancy");

  $formnum = 0;
  $formlength = count($formarr);

  for ($i = 0; $i < $formlength; $i++) {
    if (isset($_POST['fastfood'])) {
      $formnum++;
    }

    if (isset($_POST['casual'])) {
      $formnum++;
    }

    if (isset($_POST['sitdown'])) {
      $formnum++;
    }

    if (isset($_POST['fancy'])) {
      $formnum++;
    }
  }

  if ($formnum >= 1) {
    $where .= " AND (";
    $temp = "";

    if (isset($_POST['fastfood'])) {
      $temp .= " OR Formality = \"Fast Food\"";
    }

    if (isset($_POST['casual'])) {
      $temp .= " OR Formality = \"Casual\"";
    }

    if (isset($_POST['sitdown'])) {
      $temp .= " OR Formality = \"Sit-Down\"";
    }

    if (isset($_POST['fancy'])) {
      $temp .= " OR Formality = \"Fancy\"";
    }

    $temp = substr($temp, 4);
    $where .= $temp;

    $where .= ")";
  }


  if (isset($_POST['type'])) {
    if ($_POST['type'] == "rest") {
      $from .= " NATURAL JOIN Restaurant";
    }
    if ($_POST['type'] == "bar") {
      $from .= " NATURAL JOIN Bar";
    }
    if ($_POST['type'] == "dessert") {
      $from .= " NATURAL JOIN Dessert";
    }
    if ($_POST['type'] == "cafe") {
      $from .= " NATURAL JOIN Cafe";
    }
  }



  $pricearr = array("onemoney", "twomoney", "threemoney");

  $pricenum = 0;
  $pricelength = count($pricearr);

  for ($i = 0; $i < $pricelength; $i++) {
    if (isset($_POST['onemoney'])) {
      $pricenum++;
    }

    if (isset($_POST['twomoney'])) {
      $pricenum++;
    }

    if (isset($_POST['threemoney'])) {
      $pricenum++;
    }
  }

  if ($pricenum >= 1) {
    $where .= " AND (";
    $temp = "";

    if (isset($_POST['onemoney'])) {
      $temp .= " OR Price_Range = '$" . "'";
    }

    if (isset($_POST['twomoney'])) {
      $temp .= " OR Price_Range = '$$" . "'";
    }

    if (isset($_POST['threemoney'])) {
      $temp .= " OR Price_Range = '$$$" . "'";
    }

    $temp = substr($temp, 4);
    $where .= $temp;

    $where .= ")";
  }

  $sql .= $select . $from . $where;

  //  echo $sql;


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
    <th>Address</th>
    <th>Phone Number</th>
    <th>Add Favorite</th>
    <th>View Menu</th>
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
      $favs = $row['Number_of_Favorites'];

      // echo '<pre>';
      // print_r($row);
      // echo '</pre>';

      echo "
      <tr>
      <td width=\"10%\"><center> $name </center><br>
      $favs
      </td>
      <td width=\"70%\"><center> $address </center></td>
      <td width=\"10%\"><center> $phone </center></td>
      <td width=\"10%\"><center>
          <form action = 'addFavorite.php' method = 'POST'>
             <input type = 'submit' name = 'submit' value = 'add to favorites' class = 'submit'/>
             <input type = 'hidden' name = 'Venue_ID' value = $ID/>
          </form>
      </td>
      <td width=\"10%\"><center>
          <form action = 'menu.php' method = 'POST'>
             <input type = 'submit' name = 'submit' value = 'menu' class = 'submit'/>
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
