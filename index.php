<html>
<head>
	<title>Smith Woodshop</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="wwstyle.css" type="text/css">
</head>
<body>

<?php
include "fooldal.php";
include "db_connect.php";
include "products.php";
include "db_user.php";
include "shopping.php";

if (isset($_SESSION["username"])) {
	$username = $_SESSION["username"];
	$res = db_userdata($username);
	$row = mysqli_fetch_assoc($res);
	$administrator = $row["admin"];
}
else {
	$administrator = 0;
}

menu($administrator);

if (isset($_POST["putincart"])) {
	db_putincart($_POST["termekid"], $username);
}
elseif (isset($_POST["deletefromcart"])) {
	db_deletefromcart($_POST["termekid"], $username);
}

if (isset($_POST["shoppingcart"])){
	showmycart($username);
}
elseif (isset($_POST["orders"])) {
	showorder($username);
}
elseif (isset($_POST["placeorder"])) {
	db_placeorder($username);
}

if (isset($_POST["cat"]))
{
	termeklista($_POST["cat"], $administrator);
	if (isset($_POST["termekmodositas"]))
		termekmodosit($_POST["termekid"], $_POST["cat"]);
	elseif (isset($_POST["termekupdate"]))
		db_termekmodosit($_POST, $_POST["cat"]);
	elseif (isset($_POST["ujtermek"]))
		ujtermek($_POST["cat"]);
	elseif (isset($_POST["newtermek"])) {
		if (megfeleloAdatok($_POST)) 
			db_ujtermek($_POST, $_POST["cat"]);
	}
	elseif (isset($_POST["termektorles"]))
		termektorol($_POST["termekid"], $_POST["cat"]);
	elseif (isset($_POST["termekdelete"]))
		db_termektorles($_POST["termekid"]);
}

?>

<center>
<br>
<p id="copyrighttext">2018 &copy;Smith Woodworks, Inc.
</center>
</p>
</body>
</html>