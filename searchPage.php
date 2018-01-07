<?php
session_start();
if(!isset($_SESSION["user"]) || strcmp($_SESSION["idtype"], 'admin')==0) { //session variable not set or wrong session type
	header("Location:Logout.php"); //redirect if not logged in
}
$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Page</title>
	<link rel = "stylesheet" type = "text/css" href = "style.css"/>
	<style>
		a {
			font-size: 20px;
		}
	</style>
</head>
<body>
	<center>
		<h1>Welcome back, <?php echo "$user" ?> </h1>
		<form action="favorite.php" class="unstyled">
			<input type="submit" value="View Your Favorites" class="submit"/>
		</form>
		<h2> Charlottesville Eats Search </h2>
	</center>
	<center>

		<div class = "form">
			<form action = "search.php" method="POST">
				<table>
					<tr>
						<center><b>Type of Food or Drink:</b> <input type="text" name="typeSearch" id="typeSearch" value="" ></center>
					</tr>
					<tr>
						<center><b>Venue Name:</b> <input type="text" name="venueSearch" id="venueSearch" value="" style="width: 290px"></center>
					</tr>
					<tr>
						<td><b>Formality:</b></td>

						<td align="left">
							<input type="checkbox" id="fastfood" name="fastfood" value="fastfood"> <label for="fastfood"> Fast Food </label><br>
							<input type="checkbox" id="casual" name="casual" value="casual"> <label for="casual"> Casual </label><br>
							<input type="checkbox" id="sitdown" name="sitdown" value="sitdown"> <label for="sitdown"> Sit-Down </label><br>
							<input type="checkbox" id="fancy" name="fancy" value="fancy"> <label for="fancy"> Fancy </label><br>
						</td>

						<td><b>Venue Type:</b></td>

						<td align="left">
							<input type="radio" id="type" name="type" value="rest"> <label for="rest"> Restaurant </label><br>
							<input type="radio" id="type" name="type" value="bar"> <label for="bar"> Bar </label><br>
							<input type="radio" id="type" name="type" value="dessert"> <label for="dessert"> Dessert </label><br>
							<input type="radio" id="type" name="type" value="cafe"> <label for="cafe"> Cafe </label><br>
						</td>

						<td><b>Price Range:</b></td>

						<td align="left">
							<input type="checkbox" id="onemoney" name="onemoney" value="onemoney"> <label for="onemoney"> $ </label><br>
							<input type="checkbox" id="twomoney" name="twomoney" value="twomoney"> <label for="twomoney"> $$ </label><br>
							<input type="checkbox" id="threemoney" name="threemoney" value="threemoney"> <label for="threemoney"> $$$ </label><br>
						</td>
					</tr>


					<!-- <tr>
						<td colspan="6">
						<center>
							<input type="checkbox" id="combine" name="combine" value="combine"> <label for="combine"> Match All Search Preferences</label><br>
						</center>
					</td>
					</tr> -->

				</table>
				<center>
					<br>
					<a href="dietary.php">View Dietary Accommodation Options</a>
					<br><br>
					<input type="reset" value="Reset" class="reset"/>
					&nbsp; &nbsp; &nbsp; &nbsp;
					<input type="submit" value="Search" class="submit"/>
				</center>

			</form>

		</div>

		<br><br>
		<form action="Logout.php" class="none">
			<input type="submit" value="Logout" class="submit"/>
		</form>
	</center>
</body>

</html>
