<?php
session_start();
if(strcmp(!isset($_SESSION["user"]) || $_SESSION["idtype"], 'admin')==0) { //session variable not set or wrong session type
	header("Location:Logout.php"); //redirect if not logged in
}
$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Page</title>
	<link rel = "stylesheet" type = "text/css" href = "style.css"/>
</head>
	<h1><?php echo "$user"?>'s Favorites</h1> <br/>
	<body onload = 'refreshPage("")'>
		</table></br></br></center></div>
		<center><div ID = "favorites"></div></center>
		<center><div ID = "insert"></div></center>
		<script type = "text/javascript">
		var divVar = document.getElementById("favorites");
		var insertVar = document.getElementById("insert");
		var Favorites = new Array();

		function refreshPage(id) { //initial refreshing of the page if different viewing options are chosen
			var httpRequest;
			if (window.XMLHttpRequest) { // Mozilla, Safari, ...
				httpRequest = new XMLHttpRequest();
				if (httpRequest.overrideMimeType) {
					httpRequest.overrideMimeType('text/xml');
				}
			}
			else if (window.ActiveXObject) { // IE
				try {
					httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch (e) {
					try {
						httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
					}
					catch (e) {}
				}
			}
			if (!httpRequest) {
				alert('Giving up :( Cannot create an XMLHTTP instance');
				return false;
			}
			var data = 'venueID=' + id;

			httpRequest.open('POST', 'showFavorites.php', true);
			httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			httpRequest.onreadystatechange = function() { getFavorites(httpRequest); };
			httpRequest.send(data);
		}

		function getFavorites(httpRequest) {
			if(httpRequest.readyState == 4) {
				if(httpRequest.status == 200) {
					Favorites = JSON.parse(httpRequest.responseText);
					showFavorites(Favorites);
				}
			}
		}

		function showFavorites(response) { //show the table
			var theseTickets = response;
			var arrSize = theseTickets.length;
			divVar.innerHTML = "";
			var table = document.createElement("table");
			table.setAttribute("border", "1");
			table.innerHTML += "<caption><h3>Charlottesville Favorite Venues</h3></caption><tr align = 'center'><th>Venue ID</th><th>Venue Name</th><th>Date Added</th><th>Description</th><th>Hours</th><th>Phone</th><th>Delete</th></tr>";
			for(var i=0;i<arrSize;i++) {
				var tr = document.createElement("tr");
				tr.setAttribute("align", "center");
				var id = document.createTextNode(theseTickets[i].id); var name =  document.createTextNode(theseTickets[i].name); var date =  document.createTextNode(theseTickets[i].date); var description =  document.createTextNode(theseTickets[i].description); var hours =  document.createTextNode(theseTickets[i].hours); var phone =  document.createTextNode(theseTickets[i].phone);

				var tdid = document.createElement("td");
				tdid.appendChild(id);

				var tdname = document.createElement("td");
				tdname.appendChild(name);

				var tddate = document.createElement("td");
				tddate.appendChild(date);

				var tddescription = document.createElement("td");
				tddescription.appendChild(description);

				var tdhours = document.createElement("td");
				tdhours.appendChild(hours);

				var tdphone = document.createElement("td");
				tdphone.appendChild(phone);

				tr.appendChild(tdid); tr.appendChild(tdname); tr.appendChild(tddate); tr.appendChild(tddescription); tr.appendChild(tdhours); tr.appendChild(tdphone);
				tr.innerHTML += "<td><input type = 'submit' value = 'delete' class = 'submit' onclick = 'refreshPage("+parseInt(theseTickets[i].id)+")'>";
				table.appendChild(tr);
			}
			divVar.appendChild(table);
		}
		</script>

		<form action="searchPage.php" class="unstyled">
	   		<input type="submit" value="Go Back to Search Page" class="submit"/>
	  	</form>

		<form action="Logout.php" class="unstyled">
			<input type="submit" value="Logout" class="submit"/>
		</form>
	</body>
</html>
