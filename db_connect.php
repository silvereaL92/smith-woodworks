<?php
include "globals.php";

function connect()
{
	global $host, $user, $pass, $db;
	$con = mysqli_connect($host, $user, $pass, $db);
	if ($con)
	{
		mysqli_query($con, "SET NAMES 'utf8'");
		mysqli_query($con, "SET CHARACTER SET 'utf8'");
		mysqli_query($con, "SETCOLLATION_CONNECTION='utf8_general_ci'");
	}
	return $con;
}
?>