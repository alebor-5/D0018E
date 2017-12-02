<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';

//Används för att tömma varukorgen både för non-users och users!
	if (isset($_GET["resCart"]))  {
		if(isset($_SESSION["orderId"])){		//För inloggade, om varukorgen töms används fortfarande samma varukorg!!!!!!!!!!!!!

			$sql = "DELETE FROM ShoppingCart WHERE OrderID=" . $_SESSION["orderId"]  . "";
			if ($conn->query($sql) === TRUE) {
				echo "Din varukorg är nu tömd";			//DENNA MÅSTE FIXAS GRAFISKT
			}
			else {
				echo "Något gick snett: " . $conn->error;
			}
		}
		else{	//För icke inloggade
			unset($_SESSION['prodIDs']);	//Om en icke-inloggad tömde hela inkogen med session_unset() så tömdes även sessions för beställning
	}

	}

//Detta används för att ta bort en vara från varukorgen
	if (isset($_GET["remove"])){
		unset($_SESSION['prodIDs'][$_GET["remove"]]);
		echo "Varan har tagits borts!";
	}

	if (isset($_GET["removeUser"])){
		
		$sql = "DELETE FROM ShoppingCart WHERE ProductID=" . $_GET["removeUser"]  . "";
		if ($conn->query($sql) === TRUE) {
			echo "Varan har tagits bort från din varukorg!";
		}
		else {
			echo "Något gick snett: " . $conn->error;
		}

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


			$sql = "SELECT name, Cost, URL FROM Inventory WHERE ProductID=" . $tempId  . "";
			$result = $conn->query($sql);

			while($row = $result->fetch_assoc()) { //WHERE ProductID sql queryn ger endast en rad? borde ha if istället för while? Undrar bara om jag har förstått rätt
			 //echo $row["name"]. "  Cost: " . $row["Cost"]. "  antal:" .  $quant;
			$summa += $quant * $row["Cost"];
			$totalquantity += $quant;
			$filename = $row["URL"];


			echo "<div class='cart-placer'><img src='" . $filename . "' class='smallpic' /> <div class='cartName'>" . $row["name"]. "</div>";
			echo	"<form action='shoppingcart.php' method='get'><input type='hidden' name='remove' value=" . $tempId . " ><input type='submit' value='' /></form>
			<div class='cartCost'>  " . $row["Cost"]. " kr </div><div class='cartQuant'> " . $quant. "st</div>
			</div>";

			}
		}

	}
}

if(isset($_SESSION['user']) && isset($_SESSION['orderId'])){

	$sql = "SELECT ShoppingCart.ProductID, Inventory.name, ShoppingCart.Quantity, Inventory.Cost FROM ShoppingCart INNER JOIN Inventory ON ShoppingCart.productID = Inventory.productID WHERE OrderID =" . $_SESSION['orderId'] . "";
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
			$summa = $summa + $row["Cost"] * $row["Quantity"];
			$totalquantity += $row["Quantity"];




echo "<div class='cart-placer'><img src='" . $filename . "'/> <div class='cartName'>" . $row["name"]. "</div>";
			echo	"<form action='shoppingcart.php' method='get'><input type='hidden' name='removeUser' value=" . $row["ProductID"] . " ><input type='submit' value='' /></form>
			<div class='cartCost'>  " . $row["Cost"]. " kr </div><div class='cartQuant'> " . $row["Quantity"]. "st</div>
			</div>";
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
