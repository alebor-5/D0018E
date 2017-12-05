<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	include_once 'extra/admincheck.php';
	
	
	

	
?>
<div id="body-wr1">

<?php
	if(isset($_POST["prodId"]) && isset($_POST["name"]) && isset($_POST["quantity"]) && isset($_POST["height"]) && isset($_POST["weight"]) && isset($_POST["cost"]) &&isset($_POST["url"]) && isset($_POST["description"])){
		$conn->query("SET NAMES utf8");
		$sql = "UPDATE Inventory SET Name = '" . $_POST["name"] . "', Quantity = '" . $_POST["quantity"] . "', Height = '" . $_POST["height"] . "', Weight = '" . $_POST["weight"] . "', Cost = '" . $_POST["cost"] . "', URL = '" . $_POST["url"] . "', Description = '" . $_POST["description"] . "'  WHERE productID = " . $_POST["prodId"] . "" ;
		$result = $conn->query($sql);
		echo "Produkten har nu uppdaterats!";
	}
?>

<div class='adminProductRow'>
	<form>
		<input type='text' name='prodId' value="PID" readonly />
		<input type='text' name='name' value="Namn" readonly />
		<input type='text' name='quantity' value="Antal"  readonly />
		<input type='text' name='height' value="Höjd" readonly />
		<input type='text' name='weight' value="Vikt" readonly />
		<input type='text' name='cost' value="Pris" readonly />
		<input type='text' name='url' value="URL till bild" readonly />
		<textarea rows='2' cols='40' name='description' readonly >Beskrivning av produkten</textarea>

	</form>
</div>		
<?php

	$conn->query("SET NAMES utf8");
	$sql = "SELECT * FROM Inventory";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		echo "<div class='adminProductRow'>
		<form action='adminmodify.php' method='post'>
			<input type='text' name='prodId' value='". $row["ProductID"] . "' readonly />
			<input type='text' name='name' value='". $row["Name"] . "' />
			<input type='text' name='quantity' value='". $row["Quantity"] . "' />
			<input type='text' name='height' value='". $row["Height"] . "' />
			<input type='text' name='weight' value='". $row["Weight"] . "' />
			<input type='text' name='cost' value='". $row["Cost"] . "' />
			<input type='text' name='url' value='". $row["URL"] . "' />
			<textarea rows='2' cols='40' name='description'>" . $row["Description"] . "</textarea>
			<input type='submit' value='Uppdatera' />
		</form></div>";
		
	}

?>

</div>
</body>
</html>