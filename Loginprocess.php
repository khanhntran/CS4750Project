<?php
	session_start(); //keep track of the current admin
	  require_once('./library.php');
		$con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
		if (mysqli_connect_errno()) {
		  echo("Can't connect to MySQL Server. Error code: " .
		       mysqli_connect_error());
		  return null;
		}
		$user = rtrim($_POST["ID"]);
		$x = rtrim($_POST["password"]);
		$pass = hash('sha256', $x); //hash the password typed by the admin and check w/ database
		$query = "select * from User where username = '$user' and password = '$pass'";
		$result = $con->query($query) or die ("Invalid query" . $con->error);
		$rows = $result->num_rows;
		if($rows == 0): //not valid user
			unset($_SESSION["user"]); //unset the session variable
			header("Location:Login.php"); //redirect back to Login
		elseif($rows > 0):
			$row = $result->fetch_array();
			$_SESSION["user"] = $_POST["ID"];
			if(strcmp($row[2], "administrator") == 0) { //if admin, redirect to admin main page
				$_SESSION["idtype"] = "admin";
				header("Location:adminPage.php");
			}
			elseif(strcmp($row[2], "user") == 0) {
				$_SESSION["idtype"] = "user";
				header("Location:searchPage.php"); //if not, redirect to user home page
			}
		endif;
?>
