<?php 

function db_userdata($username)
{
	if (!($con = connect()))
		return null;
	$res = mysqli_query($con, "select * from user where username='" . $username . "'");
	mysqli_close($con);
	return $res;
}

?>