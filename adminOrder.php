<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	include_once 'extra/admincheck.php';
	
	
	

	
?>
<div id="body-wr">

<?php
	if(isset($_GET["ordId"]) && isset($_GET["isUser"])){
		$name = "";
		$email = "";
		$address = "";
		$zipcode = "";
		
		if($_GET["isUser"] == false){
			$sql = "SELECT FirstName, LastName, Email, Address, ZipCode FROM Orders WHERE OrderID=" . $_GET["ordId"] ."";
			$result = $conn->query($sql);
			if($row = $result->fetch_assoc()){
				$name = $row["FirstName"] . " " . $row["LastName"];
				$email = $row["Email"];
				$address = $row["Address"];
				$zipcode = $row["ZipCode"];
			}
		}
		else{
			$conn->query("SET NAMES utf8");		//Denna behövs för att få åäö korrekt!
			$sql = "SELECT AccountID FROM Orders WHERE OrderID=" . $_GET["ordId"] ."";
			$result = $conn->query($sql);
			if($row = $result->fetch_assoc()){
				$sql = "SELECT FirstName, LastName, Address, ZipCode, Email FROM Account WHERE AccountID=" . $row["AccountID"] . "";
				$result = $conn->query($sql);
				if($row = $result->fetch_assoc()){
					$name = $row["FirstName"] . " " . $row["LastName"];
					$email = $row["Email"];
					$address = $row["Address"];
					$zipcode = $row["ZipCode"];
				}
			}
		}
		
			echo "<div class='adminOrderPlace'>
				<table>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Address</th>
						<th>ZipCode</th>
					</tr>
					<tr>
						<td>". $name . "</td>
						<td>". $email . "</td>
						<td>". $address . "</td>
						<td>". $zipcode . "</td>
					</tr>
				</table>
				

				</div>";
	}
	else{
		header("Location: index.php");
	}

?>

<div id="orderCart">
	<table>
		<tr>
			<th>ProductID</th>
			<th>Quantity</th>
		</tr>
	<?php
		$conn->query("SET NAMES utf8");		//Denna behövs för att få åäö korrekt!
		$sql = "SELECT ProductID, Quantity FROM ShoppingCart WHERE OrderID=" . $_GET["ordId"] ."";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			echo "
			<tr>
				<td> " . $row["ProductID"] . " </td>
				<td> " . $row["Quantity"] . " </td>
			</tr>";
			
		}
	
	?>
	</table>
	<form action="checkorders.php" method="post">
		<input type="hidden" name="done" value="<?php echo $_GET["ordId"]; ?>" />
		<input type="submit"  value="Markera order som skickad och färdig" />
	</form>

</div>


</div>
</body>
</html>