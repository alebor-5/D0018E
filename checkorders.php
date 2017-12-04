<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	include_once 'extra/admincheck.php';
	

	
?>
<div id="body-wr">
<?php
	if(isset($_POST["done"])){
		$datetime = date_create()->format('Y-m-d H:i:s'); //Hämta tiden från server och använd denna som orderdate
		$sql = "UPDATE Orders SET ShippedDate = '" . $datetime . "' WHERE OrderID='". $_POST["done"] . "'" ;
		$result = $conn->query($sql);
		echo "OrderID: " . $_POST["done"] . " har nu skickats.";
	}

?>



<div id="order-wr">
	<div class="orderPlacer">
		<div class="adminOrder">
			OrderID
		</div>
		<div class="adminDate">
			Orderdatum
		</div>
	
	</div>

<?php
		$conn->query("SET NAMES utf8");		//Denna behövs för att få åäö korrekt!
		$sql = "SELECT OrderID, AccountID, OrderDate FROM Orders WHERE OrderDate IS NOT NULL AND ShippedDate IS NULL";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			$tempCheckIfUser = True;
			if($row["AccountID"] == NULL){
				$tempCheckIfUser = False;
			}
			echo "<div class='orderPlacer'>
			<div class='adminOrder'>". $row["OrderID"] . "</div>
			<div class='adminDate'>" . $row["OrderDate"] . "</div>
			<form action='adminOrder.php' method='get'>
				<input type='hidden' name='ordId' value='" . $row["OrderID"] . "'>
				<input type='hidden' name='isUser' value='" . $tempCheckIfUser . "'>
				<input type='submit' value='Behandla order'>
			</form>
			</div>";
			
		}
?>
</div>
</div>
</body>
</html>