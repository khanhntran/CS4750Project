<?php
	require_once('./library.php');
		$con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
		if (mysqli_connect_errno()) {
		  echo("Can't connect to MySQL Server. Error code: " .
		       mysqli_connect_error());
		  return null;
		}
	header('Content-type: text/xml');
	if(($_POST["name"] != "") && ($_POST["password"] != "") && ($_POST["password1"] != "") && strcmp($_POST["password"], $_POST["password1"])==0):
		$username = $_POST["name"];
		$password = hash('sha256', $_POST["password"]);
		$query = "insert into User values('$username', '$password', 'user')";
		$con->query($query);
		echo "<h3>Success! You are now registered with user ID $username.</h3>";
	else:
		echo "<h3>There was an error with your registration. Please try again.</h3><br/><br/><a href=newuser.php>Try Again</a>";
	endif;
?>
