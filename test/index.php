<!DOCTYPE html>
<html>
<body>

<h1>Dorm Master 9000</h1>

<form action="index.php" method="post">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
<input type="submit">
</form>

<?php
$hello = "hello";
$howareyou = "how are you";

class Test {
function hello($i) {
	global $howareyou, $hello;
	$this->hello = $hello . ". ";
	$this->hello .= $howareyou;
	$this->hello = "$hello I was wondering $i";
}
}

$test = new Test();
$test->hello(0xA);
echo($test->$hello . "<br>");
var_dump($test->$hello);
?>

</body> 