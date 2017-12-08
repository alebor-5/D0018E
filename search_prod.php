<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	
?>
<div id="body-wr">
<?php
if(isset($_GET["Search"])){
	$sql = "SELECT ProductID, name, Quantity, Cost, URL FROM Inventory WHERE Name LIKE '%" . $_GET["Search"] . "%'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
				$filename = $row["URL"];

			echo "<div class='main-placer'><a class='linktoprod' href='product.php?prodId=" . $row['ProductID'] . "'><img src='" . $filename . "' class='smallpic' /> <div class='indexName'>" . $row["name"]. "</div><div class='indexCost'>" . $row["Cost"]. " kr </div> <div class='indexQuantity'>" . $row["Quantity"]. "st</div>
			<div class='indexRating'>".writeRating($row['ProductID'])."</div>	</a>
			<div class='indexForm'><form action='index.php' method='get'>
			<input id='quantity' name='quantity' type='number' value='1' min='1' max='".  $row["Quantity"] ."' />
			<input id='prodId' name='prodId' type='hidden' value=" . $row["ProductID"]. ">

			<input type='submit' value='Lägg till' ></form></div></div>";		//Raden ovan är till för att skicka med vilket produktID. Här någonstans borde vi lägga till så att man kan välja antal.
			 //OBS OBS, form validation på serversidan måste ske här

		}

	} else {
		echo "Det fanns ingen produkt med detta namnet!";
	}
}
else{
	
}
?>
</div>
<body>
</html>