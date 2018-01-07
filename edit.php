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
	
	$fields = array('Venue_ID', 'name', 'address', 'phone', 'hours', 'formality', 'price', 'description');
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
	$error_msg = $error_msg . '<a href="adminUpdate.php">Back</a>';

	if($error) {
		echo $error_msg;
	}
	else{

                $name = addslashes($_POST['name']);
                $address = addslashes($_POST['address']);
                $desc = addslashes($_POST['description']);
                $hours = addslashes($_POST['hours']);



	$sql="UPDATE Venue SET Name = '$name', Address = '$address', Phone_Number = '$_POST[phone]', Hours = '$hours', Kid_Friendly = $_POST[kid], Formality = '$_POST[formality]', Price_Range = '$_POST[price]', Description = '$desc' WHERE Venue_ID = $_POST[Venue_ID]";

	$msg="Updated Venue <br>";

        if (mysqli_query($con, $sql))
	{
		$venue_id = mysqli_insert_id($con);
		$msg = $msg . "Venue_ID = " . $_POST['Venue_ID'] . "<br>";
		echo $msg . "<br>" . '<a href="adminUpdate.php">Back</a>';
	}
	else
	{
    		echo "Error Updating Venue: " . mysqli_error($con) . "<br>" . $sql;
	}
	}

	mysqli_close($con);

	?>

</html>
