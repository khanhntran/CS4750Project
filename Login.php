<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link rel = "stylesheet" type = "text/css" href = "style.css"/>
	</head>
	<body>
	<div class = "header">
	<h3><center>Login to Charlottesville Eats (User or Admin)</center></h3>
	</div>
	<div class = "form">
	<form action = "Loginprocess.php" method="POST">
		Enter your Username: <input type = "text" name = "ID" size = "30" maxlength = "30"> <br/>
		Enter your Password: <input type = "password" name = "password" size = "30" maxlength = "30"> <br/>
		<input type = "submit" value = "Login" class = "submit">
		</br>
		</br>Not Registered? <a href = "newuser.php">Make An Account Here</a>
	</form>
	</div>
	</body>
</html>
