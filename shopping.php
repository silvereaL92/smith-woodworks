<?php 

include "db_shopping.php";


function showmycart($username)
{
	$res = db_cartelements($username);
	if (!$res)
		die(mysqli_connect_error());
	if (!mysqli_num_rows($res))
		echo "<p><center><b>A kosár üres.</b></center>\n";
	else
	{
		?>
		<center>
		<table class="products" border="1" width="80%">
			<col width="350px">
			<tr>
				<th>Kép
				<th>Név
				<th>Ár
				<!--<th>Darab-->
				<th>Törlés
		<?php
		$ar = 0;
		while ($row = mysqli_fetch_assoc($res))
		{
			//$qtyres = db_productqty($username, $row["ID"]);
			//$qtyrow = mysqli_fetch_assoc($qtyres);
			//$qty = $qtyrow["qty"];
			echo "<tr>\n";
			echo "<td align=\"left\">" . "<img src=" . $row['imgURL'] . " alt=\"Smiley face\" height=\"350px\" width=\"350px\">" . "\n";
			echo "<td align=\"center\">" . $row['Name'] . "\n";
			echo "<td align=\"center\">" . $row['Price'] . "\n";
			//echo "<td align=\"center\">" . $qty . "\n";
			echo "<td align=\"center\" valign=\"middle\">\n";
			echo "<form action=\"index.php\" method=\"POST\">\n";
			echo "<input type=\"hidden\" name=\"shoppingcart\" value=\"productsincart\"/>";
			echo "<input type=\"hidden\" name=\"termekid\" value=\"" . $row["ID"] . "\">\t";
			echo "<input type=\"submit\" name=\"deletefromcart\" value=\"Torles a kosarbol!\">\t";
			echo "</form>";
			$ar += $row['Price'];
				
		}
		?>
		</table>
		</center>
		<?php
		echo "<form id='rendelform' action=\"index.php\" method=\"POST\">\n";
		echo "<input type=\"submit\" name=\"placeorder\" value=\"Rendeles!\">\t";
		echo "</form>";
		echo "<p id='footer'>Összesen: " . $ar . " RON\n";
	}
}

function showorder($username)
{
	$res = db_orderelements($username);
	if (!$res)
		die(mysqli_connect_error());
	if (!mysqli_num_rows($res))
		echo "<p><center><b>Nincs rendelés leadva.</b></center>\n";
	else
	{
		?>
		<center>
		<table class="products" border="1" width="80%">
			<col width="350px">
			<tr>
				<th>Kép
				<th>Név
				<th>Ár
		<?php
		$ar = 0;
		while ($row = mysqli_fetch_assoc($res))
		{
			echo "<tr>\n";
			echo "<td align=\"left\">" . "<img src=" . $row['imgURL'] . " alt=\"Smiley face\" height=\"350px\" width=\"350px\">" . "\n";
			echo "<td align=\"center\">" . $row['Name'] . "\n";
			echo "<td align=\"center\">" . $row['Price'] . "\n";
			$ar += $row['Price'];
		}
		?>
		</table>
		</center>
		<?php
		echo "<p id='footer'>Összesen: " . $ar . " RON";
	}
}

?>