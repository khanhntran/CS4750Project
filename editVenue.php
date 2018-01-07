<?php
session_start();
if(!isset($_SESSION["user"]) || strcmp($_SESSION["idtype"], 'user')==0) { //session variable not set or wrong session type
	header("Location:Logout.php"); //redirect if not logged in
}
$user = $_SESSION["user"];

        require_once('./library.php');
                $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
                if (mysqli_connect_errno()) {
                  echo("Can't connect to MySQL Server. Error code: " .
                       mysqli_connect_error());
                  return null;
                }

        $Venue_ID = substr($_POST["Venue_ID"], 0, -1);

        $sql = "SELECT * FROM Venue WHERE Venue_ID = $Venue_ID";

        if (mysqli_query($con, $sql))
        {

		$results  = mysqli_query($con,$sql);
      		$row  = mysqli_fetch_assoc($results);
      		$name = $row['Name'];
      		$address = $row['Address'];
	      	$phone = $row['Phone_Number'];
      		$desc = $row['Description'];
      		$hours = $row['Hours'];
     		$cuisine = $row['Cuisine'];
      		$formality = $row['Formality'];
      		$price = $row['Price_Range'];
      		$kid = $row['Kid_Friendly'];
		if ($kid == "1")
			$kid_val = "Yes";
		else
		{
			$kid = "0";
			$kid_val = "No";
		}
	}
	else
        {
                echo "Error getting row " . mysqli_error($con) . $Venue_ID;
        }



?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
  <title>Edit Venue</title>
  <link rel = "stylesheet" type = "text/css" href = "style.css"/>
</head>
<body>
  <h2>Edit Venue</h2>

  <form action="edit.php" method="post">
    <table>

      <tr><td><center><b>Venue Name: </b></td><td><input type="text" name="name" value="<?php echo $name; ?>" style="width:240px"></td></center></tr>
      <tr><td><center><b>Address: </b></td><td><input type="text" name="address"  value="<?php echo $address; ?>" style="width:270px"></td></center></tr>
      <tr><td><center><b>Phone Number: </b></td><td><input type="text" name="phone"  value="<?php echo $phone; ?>"></td></center></tr>
      <tr><td><center><b>Hours: </b></td><td><input type="text" name="hours"  value="<?php echo $hours; ?>" style="width:285px"></td></center></tr>
      <tr>
        <td><b>Description: </b></td>
        <td><textarea name="description" id="description" rows="4" cols="33"><?php echo $desc; ?></textarea></td>
      </tr>
    </table>
    <table>
      <tr>
        <center>
          <td></td>
          <td><b>Kid Friendly?</b></td>
          <td>
            <select name="kid">
	      <option value="<?php echo $kid; ?>"><?php echo $kid_val; ?></option>
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
            <option value="<?php echo $formality; ?>"><?php echo $formality; ?></option>
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
	    <option value="<?php echo $price; ?>"><?php echo $price; ?></option>
            <option value="$">$</option>
            <option value="$$">$$</option>
            <option value="$$$">$$$</option>
          </select>
        </td>
      </tr>
    </table>
    <br>
    <input type="hidden" value=<?php echo $Venue_ID; ?> name="Venue_ID"/>
    <input type="submit" value="Submit" class="submit"/>
  </form>
  <br>
  <form action="Logout.php" class="unstyled">
    <input type="submit" value="Logout" class="logout"/>
  </form>
</body>
</html>

