<?php

function db_termeklista($cat)
{
	if (!($con = connect()))
		return null;
	$res = mysqli_query($con, "select * from products where category='" . $cat . "'");
	mysqli_close($con);
	return $res;
}

function db_termekadatok($id)
{
	if (!($con = connect()))
		return null;
	$q = "select * from products where ID = '" . $id . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return $res;
}

function db_termekmodosit($a)
{
	if (!($con = connect()))
		return null;
	$q = "update products set ";
	$q .= "Name='" . $a["Name"] . "', "
		. "Description='" . $a["Description"] . "', "
		. "imgURL='" . $a["imgURL"] . "', "
		. "Category='" . $a["Category"] . "', "
		. "Price='" . $a["Price"] . "', "
		. "PcsAv='" . $a["PcsAv"] . "' ";
	$q .= "where ID='" . $a["termekid"] . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return $res;	
}


function db_ujtermek($a)
{
	if (!($con = connect()))
		return null;
	$q = "insert into products values(";
	$q .= "'" . $a["Name"] . "', ";
	$q .= "NULL,";
	$q .= "'" . $a["Description"] . "', ";
	$q .= "'" . $a["imgURL"] . "', ";
	$q .= "'" . $a["Category"] . "', ";
	$q .= "'" . $a["Price"] . "', ";
	$q .= "'" . $a["PcsAv"] . "')";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return $res;
}

function db_termektorles($a)
{
	if (!($con = connect()))
		return null;
	$q = "delete from products where id='" . $a . "'";
	mysqli_query($con, $q);
	mysqli_close($con);
}

?>