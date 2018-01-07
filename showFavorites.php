<?php	
	session_start();
	if(!isset($_SESSION["user"]) || strcmp($_SESSION["idtype"], 'admin')==0) { //session variable not set or wrong session type
		header("Location:Logout.php"); //redirect if not logged in
	}
	header('Content-type: text/xml');
	require_once('./library.php');
		$con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
		if (mysqli_connect_errno()) {
		  echo("Can't connect to MySQL Server. Error code: " .
		       mysqli_connect_error());
		  return null;
		}

	$venueID = $_POST["venueID"];
	$user = $_SESSION["user"];

	if(strcmp($venueID, "")!==0) { //delete the ticket
		$query1 = "delete from favorites WHERE username = '$user' AND Venue_ID = '$venueID'";
		$result1 = $con->query($query1);
		$query = "select Venue_ID, Name, Date_Added, Description, Hours, Phone_Number FROM favorites NATURAL JOIN Venue WHERE username = '$user'";
	}
	if(strcmp($venueID, "")==0) { //just show all
		$query = "select Venue_ID, Name, Date_Added, Description, Hours, Phone_Number FROM favorites NATURAL JOIN Venue WHERE username = '$user'";
	}

	$faves = array();

	$result = $con->query($query);
	$rows = $result->num_rows;
	for($i=0; $i<$rows; $i++):
		$row = $result->fetch_array();
		$newName = addslashes($row[1]);
		$newDesc = addslashes($row[3]);
		array_push($faves, array("id"=>$row[0], "name"=>$newName, "date"=>$row[2], "description"=>$newDesc, "hours"=>$row[4], "phone"=>$row[5]));
	endfor; 

	echo json_encode($faves);
?>
