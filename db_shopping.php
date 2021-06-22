<?php  

function db_cartelements($username) {
	if (!($con = connect()))
		return null;
	$q = "select * from products inner join cartutil on products.ID = cartutil.productid inner join cart on cartutil.cartid = cart.cartid where cart.username = '" . $username . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return $res;
}

function db_orderelements($username)
{
	if (!($con = connect()))
		return null;
	$q = "select * from products inner join orderutil on products.ID = orderutil.productid inner join ordertable on ordertable.ordernr = orderutil.ordernr where ordertable.username = '" . $username . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return $res;
}

function db_cartid($username) {
	if (!($con = connect()))
		return null;
	$q = "select cartid from cart where username='" . $username . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return $res;
}

function db_ordernr($username) {
	if (!($con = connect()))
		return null;
	$q = "select ordernr from ordertable where username='" . $username . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return $res;
}

function db_putincart($productid, $username) {
	if (!($con = connect()))
		return null;
	$res = db_termekadatok($productid);
	$row = mysqli_fetch_assoc($res);
	if ($row["PcsAv"] < 1)
		die("Nincs elegendo termek");
	$q1 = "insert into cart values (NULL, '" . $username . "')";
	mysqli_query($con, $q1);
	$res = db_cartid($username);
	$row = mysqli_fetch_assoc($res);
	$id = $row["cartid"];
	$q2 = "insert into cartutil values ('" . $id . "', '" . $productid . "', '1')";
	mysqli_query($con, $q2);
	mysqli_close($con);
}

function db_deletefromcart($termekid, $username)
{
	if (!($con = connect()))
		return null;
	$res = db_cartid($username);
	$row = mysqli_fetch_assoc($res);
	$id = $row["cartid"];
	$q = "delete from cartutil where cartid='" . $id ."' and productid='" . $termekid . "'";
	mysqli_query($con, $q);
	mysqli_close($con);
}

function db_deletecart($username)
{
	if (!($con = connect()))
		return null;
	$q = "delete from cart where username='" . $username . "'";
	mysqli_query($con, $q);
	mysqli_close($con);
}

function db_placeorder($username)
{
	if (!($con = connect()))
		return null;
	$q1 = "insert into ordertable (username, ordernr, completed) values ('" . $username . "', NULL, NULL)";
	mysqli_query($con, $q1);
	$res = db_ordernr($username);
	$row = mysqli_fetch_assoc($res);
	$ordernr = $row["ordernr"];
	$res = db_cartelements($username);
	while ($row = mysqli_fetch_assoc($res)) {
		$q2 = "insert into orderutil values('" . $ordernr . "', '" . $row["productid"] ."', '" . $row["qty"] . "')";
		mysqli_query($con, $q2);
	}
	db_deletecart($username);
	mysqli_close($con);
}

function db_productqty($username, $productid)
{
	if (!($con = connect()))
		return null;
	$q = "select qty from cartutil inner join cart on cart.username ='" . $username . "' and productid='" . $productid . "'";
	$res = mysqli_query($con, $q);
	mysqli_close($con);
	return $res;
}

?>