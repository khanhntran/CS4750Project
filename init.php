<!DOCTYPE html>
<html>
	<head>
		<title>Database Initialization (ME)</title>
	</head>
	<body>
		<?php
		require_once('./library.php');
		$con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
		if (mysqli_connect_errno()) {
		  echo("Can't connect to MySQL Server. Error code: " .
		       mysqli_connect_error());
		  return null;
		}
		$butchpw = hash('sha256', "admin123");
		$query = "insert into User values('admin', '$butchpw', 'administrator')";
		$con->query($query) or die ($con->error);

		$pw = hash('sha256', "hello123");
		$query2 = "insert into User values('cvillefoodie', '$pw', 'user')";
		$con->query($query2) or die ($con->error);

      ?>
	</body>
</html>