<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	include_once 'extra/admincheck.php';
	
	
	

	
?>
<div id="body-wr">
	<div id="order-wr">
		<div class="orderPlacer">
			<div class="adminOrder">
				OrderID
			</div>
			<div class="adminDate">
				Orderdatum
			</div>
			<div class="adminDate">
				Skickat
			</div>
		</div>

<?php
		$conn->query("SET NAMES utf8");		//Denna behövs för att få åäö korrekt!
		$sql = "SELECT OrderID, AccountID, OrderDate, ShippedDate FROM Orders WHERE OrderDate IS NOT NULL AND ShippedDate IS NOT NULL ";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			$tempCheckIfUser = True;
			if($row["AccountID"] == NULL){
				$tempCheckIfUser = False;
			}
			echo "<div class='orderPlacer'>
			<div class='adminOrder'>". $row["OrderID"] . "</div>
			<div class='adminDate'>" . $row["OrderDate"] . "</div>
			<div class='adminDate'>" . $row["ShippedDate"] . "</div>
			
			</div>";
			
		}
?>
</div>
	
</div>
</body>
</html>