<?php

function menu($administrator)
{
	?>
	<center>
	<a href="index.php" id="maintitle"><b>Smith Woodworks</a></b></center>
	<?php
	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
		echo "<div class=\"loginsystem\">";
		echo "<a class='logintext' href=\"register.php\">Regisztrálás!</a> <br><br>";
	  	echo "<a class='logintext'  href=\"login.php\">Belépek!</a> <br>";
	  	echo "</div>";
	}
	else if (!($administrator)){
		echo "<div class=\"loginsystem\">";
		echo "<form action=\"index.php\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"orders\" value=\"cart\"/>";
		echo "<input type=\"image\" src=\"pictures/logo2.jpg\" width=\"55px\" height=\"55px\" alt=\"Submit feedback\"/><br>";
		echo "</form>";
		echo "<form action=\"index.php\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"shoppingcart\" value=\"cart\"/>";
		echo "<input type=\"image\" src=\"pictures/shoppingcart.png\" width=\"55px\" height=\"55px\" alt=\"Submit feedback\"/>";
		echo "</form>";
		echo "<a class='logintext'  href=\"logout.php\">Kilépek!</a>";
		echo "</div>";
	}
	else {
		echo "<div class=\"loginsystem\">";
		echo "<a class='logintext'  href=\"logout.php\">Kilépek!</a>";
		echo "</div>";	
	}
	?>
	<p align="left">
	<table id="navbar">
	<tr class='nav'>
		<td>
			<form action="index.php" method="POST">
			<input class="barelem" type="submit" name="gomb" value="Külső bútorzat">
			<input type="hidden" name="cat" value="garden">
			</form>
	<tr class='nav'>
		<td>
			<form action="index.php" method="POST">
			<input class="barelem" type="submit" name="gomb" value="Belső bútorzat">
			<input type="hidden" name="cat" value="house">
			</form>
	<tr class='nav'>
		<td>
			<form action="index.php" method="POST">
			<input class="barelem" type="submit" name="gomb" value="Kiegészítők">
			<input type="hidden" name="cat" value="accessories">
			</form>
	<tr class='nav'>
		<td>
			<form action="index.php" method="POST">
			<input class="barelem" type="submit" name="gomb" value="Dekoráció">
			<input type="hidden" name="cat" value="decorations">
			</form>
	</table>
	</p>
	<?php
}
?>
