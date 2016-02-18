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
	.error {
		color: red;
	}
	</style>
	
</head>

<body>

<?php
	$iderror = $passworderror = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") { 
			// Clean data
			$id = cleanData($_POST["id"]);
			$password = cleanData($_POST["password"]);
			if(empty($id)) {
				$iderror = "* Student ID is a required field";
				//return;
			}
			if(empty($password)) {
				$passworderror = "* Password is a required field";
				//return;
			}
		}
		
		function cleanData($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
?>

<div align="center">
	<div class="container">
		<h1>Dorm Maker</h1>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<font size="4em">
				<label>Student ID</label> <input type="text" name="id" id="margin"><span class="error"><?php echo $iderror?></span><br>
				<label>Password</label> <input type="password" name="password" id="margin"><span class="error"><?php echo $passworderror?></span><br>
				<input type="submit" id="submit" class="submit">
			</font>
		</form>
	</div>
</div>

</body> 
