<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
?>

<div id="body-wr">
<?php 
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
		
		echo "<div class='main-placer'><img src='" . $filename . "'/> Namn: " . $row["name"]. "  Cost: " . $row["Cost"]. " sek  Quantity: " . $row["Quantity"]. "st<button type='button'>Lägg till i varukorg</button></div>";
        
    }
	
} else {
    echo "There is no products in the database, please contact admin";
}
$conn->close();


?>


</div>
</body>
</html>