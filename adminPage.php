<?php
session_start();
if(!isset($_SESSION["user"]) || strcmp($_SESSION["idtype"], 'user')==0) { //session variable not set or wrong session type
  header("Location:Logout.php"); //redirect if not logged in
}
$user = $_SESSION["user"];

include_once("./library.php"); // To connect to the database
$mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$venueArray = array();
if ($result = $mysqli->query("SELECT * FROM Venue")) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $venueArray[] = $row;
    }

    $fp = fopen('venue.json', 'w');
    fwrite($fp, json_encode($venueArray));
    fclose($fp);
    json_encode($venueArray);
}

$menuArray = array();
if ($result = $mysqli->query("SELECT * FROM Menu_Item")) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $menuArray[] = $row;
    }

    $fp = fopen('menu.json', 'w');
    fwrite($fp, json_encode($menuArray));
    fclose($fp);
    json_encode($menuArray);
}

$locatedArray = array();
if ($result = $mysqli->query("SELECT * FROM located")) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $locatedArray[] = $row;
    }

    $fp = fopen('located.json', 'w');
    fwrite($fp, json_encode($locatedArray));
    fclose($fp);
    json_encode($locatedArray);
}

$servesArray = array();
if ($result = $mysqli->query("SELECT * FROM serves")) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $servesArray[] = $row;
    }

    $fp = fopen('serves.json', 'w');
    fwrite($fp, json_encode($servesArray));
    fclose($fp);
    json_encode($servesArray);
}

$result->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Insert New Information</title>
  <link rel = "stylesheet" type = "text/css" href = "style.css"/>
  <style>
    a {
      font-size: 25px;
    }
  </style>
</head>
<body>
  <h1>Welcome back, <?php echo "$user"?></h1>
  <a href="adminUpdate.php">Update an existing Venue</a><br>
  <a href="download.php?json=venue">Download Venue json</a><br>
  <a href="download.php?json=menu">Download Menu json</a><br>
  <a href="download.php?json=located">Download Located json</a><br>
  <a href="download.php?json=serves">Download Serves json</a>
  <h2>Add Venue</h2>

  <form action="adminInsert.php" method="post">
    <table>

      <tr><td><center><b>Venue Name: </b></td><td><input type="text" name="name" style="width:240px"></td></center></tr>
      <tr><td><center><b>Address: </b></td><td><input type="text" name="address" style="width:270px"></td></center></tr>
      <tr><td><center><b>Phone Number: </b></td><td><input type="text" name="phone"></td></center></tr>
      <tr><td><center><b>Hours: </b></td><td><input type="text" name="hours" style="width:285px"></td></center></tr>
      <tr>
        <td><b>Description: </b></td>
        <td><textarea name="description" id="description" rows="4" cols="33"></textarea></td>
      </tr>
    </table>
    <table>
      <tr>
        <td width="22%"></td>
        <td><b>Venue Type?</b></td>
        <td align="left">
          <input type="checkbox" name="Restaurant" value="Restaurant"> <label for="Restaurant"> Restaurant </label><br>
          <input type="checkbox" name="Bar" value="Bar"> <label for="Bar"> Bar </label><br>
          <input type="checkbox" name="Cafe" value="Cafe"> <label for="Cafe"> Cafe </label><br>
          <input type="checkbox" name="Dessert" value="Dessert"> <label for="Dessert"> Dessert </label><br>
        </td>
        <td width="27%"></td>
      </tr>
      <tr>
        <center>
          <td></td>
          <td><b>Kid Friendly?</b></td>
          <td>
            <select name="kid">
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </td>
        </center>
      </tr>

      <tr>
        <td></td>
        <td><b>Formality:</b></td>
        <td>
          <select name="formality">
            <option value="">Select...</option>
            <option value="Fast Food">Fast Food</option>
            <option value="Casual">Casual</option>
            <option value="Sit-Down">Sit-Down</option>
            <option value="Fancy">Fancy</option>
          </select>
        </td>
      </tr>

      <tr>
        <td></td>
        <td><b>Price Range:</b></td>
        <td>
          <select name="price">
            <option value="$">$</option>
            <option value="$$">$$</option>
            <option value="$$$">$$$</option>
          </select>
        </td>
      </tr>
    </table>
    <br>
    <input type="submit" value="Submit" class="submit"/>
  </form>
  <br>
  <form action="Logout.php" class="unstyled">
    <input type="submit" value="Logout" class="logout"/>
  </form>
</body>
</html>
