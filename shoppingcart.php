<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	
//Används för att tömma varukorgen!	
	if (isset($_GET["resCart"]))  {
		session_unset(); 
	}

?>

<div id="body-wr">

<?php

//Detta är för att skriva ut det som finns i varukorgen. Variabeln $tempId håller vilket productID och variabeln $quant håller antalet!
//Det som ska göras på denna sida är: Gör så att man kan ändra antal, kunna lägga order, samt snygga till det grafiska.
if(isset($_SESSION['prodIDs'])){
		
		 
	
	foreach($_SESSION['prodIDs'] as $tempId => $quant){
		
		
		$sql = "SELECT name, Cost FROM Inventory WHERE ProductID=" . $tempId  . "";
		$result = $conn->query($sql);
		
		while($row = $result->fetch_assoc()) {
		echo $row["name"]. "  Cost: " . $row["Cost"]. "<br/>";
		}
	}	
}



?>
	<form action="shoppingcart.php" method="get">
	<input id='resCart' name='resCart' type='hidden' value="1"/>
	  <input type="submit" value="Töm varukorg">
	</form>





</div>
</body>
</html>