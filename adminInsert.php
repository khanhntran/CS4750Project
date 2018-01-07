<?php
session_start();
if(!isset($_SESSION["user"]) || strcmp($_SESSION["idtype"], 'user')==0) { //session variable not set or wrong session type
	header("Location:Logout.php"); //redirect if not logged in
}
?>

<!DOCTYPE html>
<html>
	<head>
	<link rel = "stylesheet" type = "text/css" href = "style.css"/>
	</head>
	<?php
 	include_once("./library.php"); // To connect to the database
 	$con = mysqli_connect($SERVER, $USERNAME, $PASSWORD, $DATABASE);
	 // Check connection
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$fields = array('name', 'address', 'phone', 'hours', 'formality', 'price', 'description');
	$error_msg = "";
	$error = false; //No errors yet
	foreach($fields AS $fieldname) { //Loop trough each field
  		if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
    		$error_msg = $error_msg . ' Field '.$fieldname.' missing!<br />'; //Display error with field
    		$error = true;
  		}
	}
	if (preg_match('/^-?[0-9]+$/', (string)$_POST['phone']) == "") {	
		$error_msg = $error_msg . 'Phone number must include digits (0-9) only! <br />';
		$error = true;
	}
	$error_msg = $error_msg . '<a href="adminPage.php">Back</a>';

	if($error) {
		echo $error_msg;
	}
	else{
	$sql="INSERT INTO Venue (Name, Address, Phone_Number, Hours, Kid_Friendly, Formality, Price_Range, Description)
	VALUES ('$_POST[name]','$_POST[address]', '$_POST[phone]', '$_POST[hours]', '$_POST[kid]', '$_POST[formality]', '$_POST[price]', '$_POST[description]')";

	$msg="Created New Venue <br>";

        if (mysqli_query($con, $sql))
	{
		$venue_id = mysqli_insert_id($con);
		$msg = $msg . "Venue_ID = " . $venue_id . "<br>";

		if (isset($_POST['Bar']))
		{
			$sql = "INSERT INTO Bar (Venue_ID) VALUES ($venue_id)";
			if (mysqli_query($con, $sql))
				 $msg = $msg . "Bar added<br>";
			else
				$msg = $msg . "Error Adding Bar with venue ID: " . $venue_id . "<br>";
		}

		if (isset($_POST['Restaurant']))
                {
                        $sql = "INSERT INTO Restaurant (Venue_ID) VALUES ($venue_id)";
                        if(mysqli_query($con, $sql))
                        	$msg = $msg . "Restaurant added<br>";
			else
				$msg = $msg . "Error Adding Restaurant with venue ID: " . $venue_id . "<br>";
                }

		if (isset($_POST['Cafe']))
                {
                        $sql = "INSERT INTO Cafe (Venue_ID) VALUES ($venue_id)";
                        if(mysqli_query($con, $sql))
                        	$msg = $msg . "Cafe added<br>";
			else
				$msg = $msg . "Error Adding Cafe with venue ID: " . $venue_id . "<br>";
                }

		if (isset($_POST['Dessert']))
                {
                        $sql = "INSERT INTO Dessert (Venue_ID) VALUES ($venue_id)";
                        if(mysqli_query($con, $sql))
                        	$msg = $msg . "Dessert added<br>";
			else
				$msg = $msg . "Error Adding Dessert with venue ID: " . $venue_id . "<br>";
                }
		

		$msg = $msg . '<a href="adminPage.php">Back</a>';
		echo $msg;

	}
	else
	{
    		echo "Error Creating Venue: " . mysqli_error($con);
	}
	}

	mysqli_close($con);

	?>

</html>
