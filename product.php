<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
?>

<div id="body-wr">
<?php 
	if(isset($_GET["prodId"])){
		$sql = "SELECT Name, Quantity, Height, Weight, Cost, Description FROM Inventory WHERE ProductID =" . $_GET["prodId"] . "";
		$result = $conn->query($sql);
		if($row = $result->fetch_assoc()) {
			$filename =  'img/products/' . $tempId . '.png';
			if(is_file($filename)){
				$filename = 'img/products/' . $tempId . '.png';
			}
			else{
				$filename = 'img/products/standard.png';
			}
			
			echo "Najs product!"
		}
		else{
			echo "Något gick snett! Kontakta admin!";
		}
	}
	else{
		echo "Något verkar ha gått snett. <a href='index.php' title='Tillbaka till startsidan'>Tillbaka till startsidan</a>";
		
	}


?>


</div>
</body>
</html>