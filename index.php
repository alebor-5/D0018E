<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
?>

<div id="body-wr">
<?php

	//Följande är för att lägg in i shoppingcart, just nu läggs bara en till men detta är lätt fixat genom att lägga till en text input eller nåt  vid "lägg till produkt". Vi bör använda POST också men använder get för att testa
	if (isset($_GET["prodId"])){
		$_SESSION['prodIDs'][$_GET["prodId"]] = 1;

	}
	//Slut på shoppingcart
	
$sql = "SELECT ProductID, name, Quantity, Cost FROM Inventory";
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
		<form action='index.php' method='get'>
		<input id='prodId' name='prodId' type='hidden' value=" . $row["ProductID"]. "> 
		<input type='submit' ></div></form>";		//Raden ovan är till för att skicka med vilket produktID. Här någonstans borde vi lägga till så att man kan välja antal.
         
	
    }
	
} else {
    echo "There is no products in the database, please contact admin";
}
$conn->close();


?>


</div>
</body>
</html>