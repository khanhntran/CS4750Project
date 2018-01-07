<?php
	session_start();
	unset($_SESSION["user"]);
	unset($_SESSION["idtype"]);
	session_destroy();
	header("Location:Login.php");
?>
