<!DOCTYPE html>
<html>
	<head>
		<title>Create New Account</title>
		<link rel = "stylesheet" type = "text/css" href = "style.css"/>
	</head>
	<body>
	<h3><center>Create a New Account</center></h3> </br>
	<div class = "form">
	<form action = "" method = "POST">
		<input type = "text" id = "name" name = "username" size = "30" maxlength = "30" placeholder="Username"> <br/>
		<input type = "password" id = "password" name = "password" size = "30" maxlength = "30" placeholder="Password"> <br/>
		<input type = "password" id = "password1" name = "password1" size = "30" maxlength = "30" placeholder="Confirm Password"> <br/>
		<input type = "button" name = "submit" value = "Submit" class="submit"onclick = 'create()'>
	<br/></br>Already a User? <a href="Login.php">Back to Login</a>
	</form>
	</div>

	<script type = "text/javascript">
	function create() {
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
        var data = 'name=' +  encodeURIComponent(document.getElementById("name").value) + '&password=' + encodeURIComponent(document.getElementById("password").value) + '&password1=' + encodeURIComponent(document.getElementById("password1").value);

        httpRequest.open('POST', 'newuserprocess.php', true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.onreadystatechange = function() { created(httpRequest); };
        httpRequest.send(data);
	}

	function created(httpRequest) {
		if(httpRequest.readyState == 4) {
            if(httpRequest.status == 200) {
                document.body.innerHTML =  "<form>" + httpRequest.responseText + "<br/><br/><a href=Login.php>Go Back to Login</a></form>";
            }
        }
	}
	</script>
	</body>
</html>
