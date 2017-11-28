<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	
//Används för att tömma varukorgen både för non-users och users!	
	if (isset($_GET["resCart"]))  {
		if(isset($_SESSION["orderId"])){		//För inloggade, om varukorgen töms används fortfarande samma varukorg!!!!!!!!!!!!!
		
			$sql = "DELETE FROM Shoppingcart WHERE OrderID=" . $_SESSION["orderId"]  . "";
			if ($conn->query($sql) === TRUE) {
				echo "Din varukorg är nu tömd";			//DENNA MÅSTE FIXAS GRAFISKT
			} 
			else {
			echo "Något gick snett: " . $conn->error;
			}
		}
		else{	//För icke inloggade
			session_unset(); 	
	}
	
	}

//Detta används för att ta bort en vara från varukorgen 
	if (isset($_GET["remove"])){
		unset($_SESSION['prodIDs'][$_GET["remove"]]);
	}
	
	

	
?>

<div id="body-wr">

<?php
		$summa = 0;
		$totalquantity = 0; 
//Detta är för att skriva ut det som finns i varukorgen. Variabeln $tempId håller vilket productID och variabeln $quant håller antalet!
//Det som ska göras på denna sida är: Gör så att man kunna lägga order, samt snygga till det grafiska.


if(!isset($_SESSION['user'])){ //Detta är för icke inloggade användare!
	if(isset($_SESSION['prodIDs'])){

		
		foreach($_SESSION['prodIDs'] as $tempId => $quant){
			
			
			$sql = "SELECT name, Cost FROM Inventory WHERE ProductID=" . $tempId  . "";
			$result = $conn->query($sql);
			
			while($row = $result->fetch_assoc()) {
			 //echo $row["name"]. "  Cost: " . $row["Cost"]. "  antal:" .  $quant;
			$summa += $quant * $row["Cost"];
			$totalquantity += $quant;
			$filename =  'img/products/' . $tempId . '.png';
			if(is_file($filename)){
				$filename = 'img/products/' . $tempId . '.png';
			}
			else{
				$filename = 'img/products/standard.png';
			}
			
			echo "<div class='cart-placer'><img src='" . $filename . "'/> <div class='cartName'>" . $row["name"]. "</div>";
			echo	"<form action='shoppingcart.php' method='get'><input type='hidden' name='remove' value=" . $tempId . " ><input type='submit' value='' /></form>
			<div class='cartCost'>  " . $row["Cost"]. " kr </div><div class='cartQuant'> " . $quant. "st</div>
			</div>";
			
			}
		}
		   
	}
}

if(isset($_SESSION['user']) && isset($_SESSION['orderId'])){ 
	
	$test = $_SESSION['orderId'];
	//$sql = "SELECT Shoppingcart.ProductID, Inventory.name, Shoppingcart.Quantity, Inventory.Cost FROM shoppingcart INNER JOIN Inventory ON shoppingcart.productID = Inventory.productID WHERE OrderID =" . $_SESSION['orderId'] . "";
	$sql = "SELECT ShoppingCart.ProductID, Inventory.name, ShoppingCart.Quantity, Inventory.Cost FROM ShoppingCart INNER JOIN Inventory ON ShoppingCart.productID = Inventory.productID WHERE OrderID = '$test'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row	
		
		while($row = $result->fetch_assoc()) {
			
			$filename =  'img/products/' . $row["ProductID"] . '.png';
			if(is_file($filename)){
				$filename = 'img/products/' . $row["ProductID"] . '.png';
			}
			else{
				$filename = 'img/products/standard.png';
			}
			
			echo "<div class='main-placer'><img src='" . $filename . "'/> Namn: " . $row["name"]. "  Cost: " . $row["Cost"]. " sek  Quantity: " . $row["Quantity"]. "st 
			</div>";		//Raden ovan är till för att skicka med vilket produktID. Här någonstans borde vi lägga till så att man kan välja antal.
			 //OBS OBS, form validation på serversidan måste ske här
		
		}
		
	} else {
		echo "Det finns inga produkter i din varukorg";
}

}



?>
	 <div id='cartsummary'>
		<p style="text-align:right;margin-right:100px;">Antal:<b> <?php echo $totalquantity; ?> st</b></p>
		<p style="text-align:right;margin-right:100px;">Summa:<b> <?php echo $summa; ?> kr</b></p>
	 
		<form action="shoppingcart.php" method="get">
			<input id='resCart' name='resCart' type='hidden' value="1"/>
			<input type="submit" value="Töm varukorg">
		</form>
	</div>





</div>
</body>
</html>