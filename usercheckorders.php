<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	include_once 'extra/usercheck.php';

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<div id="body-wr">
	<div class="userorderbox">
		<h1>Aktiva odrar</h1>
		<p>Här är ordrar som vi håller på att packa eller kontrollerar.</p>

		<?php
			$sql = "SELECT OrderID, OrderDate FROM Orders WHERE AccountID = '" . $_SESSION["accID"] . "' AND ShippedDate IS NULL AND OrderDate IS NOT NULL";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				echo "<div class='userOrderInfo'>
						<table class='orderTable'>
							<tr>
								<th>Visa produkter</th>
								<th>OrderID</th>
								<th>Datum</th>
							</tr>";
				while($row = $result->fetch_assoc()){
					echo "
							<tr class='trBorder'>
								<td class='animateTR' id='animate" . $row["OrderID"] . "' style='cursor:pointer'>+</td>
								<td><b>" . $row["OrderID"] . "</b></td>
								<td><b>" . $row["OrderDate"] . "</b></td>
							</tr>";
					$sql2 = "SELECT OrderItems.Quantity, Inventory.Name FROM OrderItems INNER JOIN Inventory ON OrderItems.ProductID = Inventory.ProductID WHERE OrderID = '" . $row["OrderID"] . "'";
					$result2 = $conn->query($sql2);
					if($result2->num_rows > 0){
							echo "
							<tr class='animate" . $row["OrderID"] . "' style='display:none; background-color:#ccc;'>
								<th colspan='2'>Namn</th>
								<th>Antal</th>
							</tr>";
						while($row2 = $result2->fetch_assoc()){
							echo "
							<tr class='animate" . $row["OrderID"] . "' style='display:none; background-color:#ccc;'>
								<td colspan='2'>" . $row2["Name"] . "</td>
								<td>" . $row2["Quantity"] . "</td>
							</tr>";


						}

					}


				}
				echo "</table></div>";
			}
		?>


	</div>

	<div class="userorderbox">
		<h1>Gamla odrar odrar</h1>
		<p>Här kan du se dina tidigare odrar hos oss.</p>
	<?php
			$sql = "SELECT OrderID, OrderDate, ShippedDate FROM Orders WHERE AccountID = '" . $_SESSION["accID"] . "' AND ShippedDate IS NOT NULL AND OrderDate IS NOT NULL";
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				echo "<div class='userOrderInfo'>
						<table class='orderTable'>
							<tr>
								<th>Visa produkter</th>
								<th>OrderID</th>
								<th>Beställningsdatum</th>
								<th>Skickat</th>
							</tr>";
				while($row = $result->fetch_assoc()){
					echo "
							<tr class='trBorder'>
								<th class='animateTR2' id='animate2" . $row["OrderID"] . "' style='cursor:pointer'>+</th>
								<th>" . $row["OrderID"] . "</th>
								<th>" . $row["OrderDate"] . "</th>
								<th>" . $row["ShippedDate"] . "</th>
							</tr>";
					$sql2 = "SELECT OrderItems.Quantity, Inventory.Name FROM OrderItems INNER JOIN Inventory ON OrderItems.ProductID = Inventory.ProductID WHERE OrderID = '" . $row["OrderID"] . "'";
					$result2 = $conn->query($sql2);
					if($result2->num_rows > 0){
							echo "
							<tr class='animate2" . $row["OrderID"] . "' style='display:none; background-color:#ccc;'>
								<th colspan='2'>Namn</th>
								<th colspan='2'>Antal</th>
							</tr>";
						while($row2 = $result2->fetch_assoc()){
							echo "
							<tr class='animate2" . $row["OrderID"] . "' style='display:none; background-color:#ccc;'>
								<td colspan='2'>" . $row2["Name"] . "</td>
								<td colspan='2'>" . $row2["Quantity"] . "</td>
							</tr>";


						}

					}


				}
				echo "</table></div>";
			}
		?>

	</div>
</div>
<script>
$(document).ready(function(){
    $(".animateTR").click(function(){
		var id = this.getAttribute( 'id' );
		var TempText = $("#" + id).text();
		console.log(TempText);
		if(TempText== "+"){
			$("#" + id).text("-");
		}
		else{
			$("#" + id).text("+");
		}
        $("." +id).fadeToggle();

    });
});

$(document).ready(function(){
    $(".animateTR2").click(function(){
		var id = this.getAttribute( 'id' );
		var TempText = $("#" + id).text();
		console.log(TempText);
		if(TempText== "+"){
			$("#" + id).text("-");
		}
		else{
			$("#" + id).text("+");
		}
        $("." +id).fadeToggle();

    });
});

</script>
</body>
</html>
