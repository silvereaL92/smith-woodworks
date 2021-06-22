<?php
include "db_products.php";
session_start();

function termeklista($cat, $administrator)
{
if ($administrator) {
?>
	<center>
	<form action="index.php" method="POST">
		<input type="hidden" name="cat" value="<?php echo $cat; ?>">
		<input type="submit" name="ujtermek" value="Hozzaad">
	</form>
	</center>
<?php 
}
	$res = db_termeklista($cat);
	if (!$res)
		die(mysqli_connect_error());
	if (!mysqli_num_rows($res))
		echo "<p>Nem találtam termeket.\n";
	else
	{
		?>
		<center>
		<table class="products" border="1" width="70%">
			<col width="350px">
			<tr>
				<th>Kep
				<th>Nev
				<th>Leiras
				<th>Ar
				<?php
				if ($administrator) {
					echo "<th colspan=\"2\">Muveletek";
				}
				else if (isset($_SESSION["username"])){
					echo "<th colspan=\"2\">Vasarlas";
				}
		while ($row = mysqli_fetch_assoc($res))
		{
			echo "<tr>\n";
			echo "<td align=\"center\">" . "<img src=" . $row['imgURL'] . " alt=\"Smiley face\" height=\"350px\" width=\"350px\">" . "\n";
			echo "<td align=\"center\">" . $row['Name'] . "\n";
			echo "<td align=\"center\">" . $row['Description'] . "\n";
			echo "<td align=\"center\">" . $row['Price'] . "\n";
			if ($administrator) {
				echo "<td align=\"center\" valign=\"middle\">\n";
				echo "<form action=\"index.php\" method=\"POST\">\n";
				echo "<input type=\"hidden\" name=\"cat\" value=$cat>
				<input type=\"hidden\" name=\"termekid\" value=\"" . $row["ID"] . "\">\t";
				echo "<input type=\"submit\" 
				name=\"termekmodositas\" value=\"Modosít\">\t";
				echo "</form>";
				echo "<form action=\"index.php\" method=\"POST\">\n";
				echo "<input type=\"hidden\" name=\"cat\" value=$cat>
				<input type=\"hidden\" name=\"termekid\" value=\"" . $row["ID"] . "\">\t";
				echo "<input type=\"submit\" 
				name=\"termektorles\" value=\"Torles\">\t";
			}
			else if (isset($_SESSION["username"])) {
				echo "<td align=\"center\" valign=\"middle\">\n";
				echo "<form action=\"index.php\" method=\"POST\">\n";
				echo "<input type=\"hidden\" name=\"cat\" value=$cat>
				<input type=\"hidden\" name=\"termekid\" value=\"" . $row["ID"] . "\">\t";
				echo "<input type=\"submit\" name=\"putincart\" value=\"Kosarba tesz!\">";
				echo "</form>";
			}
		}
		?>
		</table>
		</center>
		<?php
	}	
}



function termekmodosit($id, $cat)
{
	$res = db_termekadatok($id);
	if (!mysqli_num_rows($res))
		echo "Nincs ilyen termek<br>\t";
	else
	{
		$row = mysqli_fetch_assoc($res);
		?>
		<center>
		<form action="index.php" method="POST">
		<input type="hidden" name="cat" value="<?php echo $cat; ?>">
		<input type="hidden" name="termekid" value="<?php echo $row["ID"]; ?>">
		<table>
			<tr>
				<td align="right">Termeknev
				<td>
				<input type="text" name="Name" value="<?php echo $row["Name"];?>">
			<tr>	
				<td align="right">Leiras
				<td>
				<input type="text" name="Description" value="<?php echo $row["Description"];?>">
			<tr>
				<td align="right">imgURL
				<td>
				<input type="text" name="imgURL" value="<?php echo $row["imgURL"];?>">
			<tr>
				<td align="right">Kategoria
				<td>
				<input type="text" name="Category" value="<?php echo $row["Category"];?>">
			<tr>
				<td align="right">Ar
				<td>
				<input type="text" name="Price" value="<?php echo $row["Price"];?>">
			<tr>
				<td align="right">Elerheto
				<td>
				<input type="text" name="PcsAv" value="<?php echo $row["PcsAv"];?>">
			<tr>
				<td align="center" colspan="2">
				<input type="submit" name="termekupdate" value="Modosit">
		</table>
		</form>
		</center>
		<?php
	}
}


function ujtermek($cat)
{
	?>
	<center>
	<form action="index.php" method="POST">
	<input type="hidden" name="cat" value="<?php echo $cat; ?>">
		<table>
			<tr>
				<td align="right">Termeknev
				<td>
				<input type="text" name="Name">
			<tr>
				<td align="right">Description
				<td>
				<input type="text" name="Description">
			<tr>	
				<td align="right">imgURL
				<td>
				<input type="text" name="imgURL">
			<tr>
				<td align="right">Category
				<td>
				<input type="text" name="Category">
			<tr>
				<td align="right">Price
				<td>
				<input type="text" name="Price">
			<tr>
				<td align="right">PcsAv
				<td>
				<input type="text" name="PcsAv">
			<tr>
				<td align="center" colspan="2">
				<input type="submit" name="newtermek" value="Mentes">
		</table>
	</form>
	</center>
	<?php
}

function ujtermek2($a, $cat)
{
	?>
	<center>
	<form action="index.php" method="POST">
	<input type="hidden" name="cat" value="<?php echo $cat; ?>">
		<table>
			<tr>
				<td align="right">Termeknev
				<td>
				<input type="text" name="Name" value="<?php echo $a["Name"]?>">
			<tr>
				<td align="right">Leiras
				<td>
				<input type="text" name="Description" value="<?php echo $a["Description"]?>">
			<tr>	
				<td align="right">Kep
				<td>
				<input type="text" name="imgURL" value="<?php echo $a["imgURL"]?>">
			<tr>
				<td align="right">Kategoria
				<td>
				<input type="text" name="Category" value="<?php echo $a["Category"]?>">
			<tr>
				<td align="right">Ar
				<td>
				<input type="text" name="Price" value="<?php echo $a["Price"]?>">
			<tr>
				<td align="right">Elerheto
				<td>
				<input type="text" name="PcsAv" value="<?php echo $a["PcsAv"]?>">
			<tr>
				<td align="center" colspan="2">
				<input type="submit" name="newtermek" value="Mentes">
		</table>
	</form>
	</center>
	<?php
}


function megfeleloAdatok($a)
{
	$ret = true;
	if ($a["Name"] == "") {
		echo "Hianyzik a nev!<br>\n";
		$ret = false; 
	}
	if ($a["Description"] == "") {
		echo "Hianyzik a leiras!<br>\n";
		$ret = false;
	}
	if ($a["imgURL"] == "") {
		echo "Hianyzik a kep!<br>\n";
		$ret = false;
	}
	if ($a["Price"] == "") {
		echo "Hianyzik az ar!<br>";
		$ret = false;
	}
	if ($a["PcsAv"] == "") {
		echo "Hianyzik a darabszam!<br>";
		$ret = false;
	}
	if (!$ret)
		ujtermek2($a);
	return $ret;
}


function termektorol($id, $cat)
{
	$res = db_termekadatok($id);
	if (!mysqli_num_rows($res))
		echo "ilyen termek dincsen";
	else
	{
		$row = mysqli_fetch_assoc($res);
		echo "<center>Valoban ki akarod torolni ";
		echo $row["Name"] . " " . "termeket?";
		?>
		<table>
		<tr>
			<td>
				<form action="index.php" method="POST">
				<input type="hidden" name="cat" value="<?php echo $cat; ?>">
				<input type="hidden" name="termekid" value="<?php echo $id; ?>">
				<input type="submit" name="termekdelete" value="Torles!">
				</form>
			<td>
				<form action="index.php" method="POST">
				<input type="hidden" name="cat" value="<?php echo $cat; ?>">
				<input type="submit" value="Megsem!">
				</form>
		</table>
		</center>
		<?php
	}
}

?>