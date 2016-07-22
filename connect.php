<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "db_laravelnews";
	$con=mysqli_connect($host,$user,$pass,$db) or die("Could not connect database");
	mysqli_select_db( $con,$db) or die("Could not select database");
	mysqli_set_charset($con, "utf8");
?>
