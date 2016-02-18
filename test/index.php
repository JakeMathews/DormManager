<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style type="text/css">
    .container {
		margin-top: 5em;
        width: 17em;
        clear: both;
    }
    .container input {
        width: 100%;
        clear: both;
    }
	#submit {
		width: 10em;  
		height: 2em;
		margin-bottom: 1em;
		margin-top: 1em;
	}
	#margin {
		height: 2em;
		margin-bottom: 1em;
		margin-top: 1em;
	}
	</style>
	
</head>

<body>

<div align="center">
	<div class="container">
		<h1>Dorm Maker</h1>
		<form action="index.php" method="post">
			<font size="4em">
				<label>Student ID</label> <input type="text" name="id" id="margin"><br>
				<label>Password</label> <input type="text" name="password" id = "margin"><br>
				<input type="submit" id="submit" class="submit">
			</font>
		</form>
	</div>
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			echo($_POST["id"]);
			//$name = $_POST["id"];
			$_SERVER["REQUEST_METHOD"] = NULL;
		}
	?>
</div>

</body> 
