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

	$Venue_ID = $_POST["Venue_ID"];
	$user = $_SESSION["user"];
	$query = "SELECT * from favorites where username = '$user' AND Venue_ID = '$Venue_ID'";
	$result = $con->query($query);
	if($result->num_rows > 0) { //already in favorites
		header("Location:errorPage.php");
	}
	else {
		$query1 = "insert INTO favorites values('$user', '$Venue_ID', CURDATE())";
		$con->query($query1) or die ("Invalid query" . $con->error);
		header("Location:favorite.php");
	}
?>
