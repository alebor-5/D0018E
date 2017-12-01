<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
?>

<div id="body-wr">
<?php
	error_reporting(E_ALL);
	ini_set('display_errors',1);
	
	//Följande är för att lägg in i shoppingcart,  Vi bör använda POST också men använder get för att testa
	if (isset($_GET["prodId"]) && isset($_GET["quantity"]) ){
		if(!isset($_SESSION['user'])){
			if(!isset($_SESSION['prodIDs'][$_GET["prodId"]])){		//dessa if else satserna är för icke inloggade!!!
				
				$_SESSION['prodIDs'][$_GET["prodId"]] =  $_GET["quantity"];
			}
			else{
				$_SESSION['prodIDs'][$_GET["prodId"]] +=  $_GET["quantity"];
			}
		}
		else{ //Dessa är för de inloggade!
			
			$sql = "SELECT OrderID FROM Orders WHERE AccountID =" . $_SESSION['accID'] . " AND OrderDate IS NULL"; //Nu skapas en ny order istället för att den gammla ersätts
			$result = $conn->query($sql);
			 
				if($result->num_rows > 0){			//Detta är om det redan finns en order tillhörande den användaren i databasen
					if($row = $result->fetch_assoc()) {
						$_SESSION['orderId'] = $row["OrderID"];
						
						$sql = "SELECT productID FROM ShoppingCart WHERE OrderID = " . $_SESSION['orderId'] . " AND ProductID = " . $_GET["prodId"] . "";																		
						$result = $conn->query($sql);
						
						if($result->num_rows > 0){	//Detta är om det redan finns en produktID tillhörande den användaren i databasen						
							if($row = $result->fetch_assoc()) {
								
								$sql = "UPDATE ShoppingCart SET Quantity = Quantity + " . $_GET["quantity"] . "  WHERE productID = " . $_GET["prodId"] . " AND orderID=" . $_SESSION['orderId'] . "" ;
								
								$result = $conn->query($sql);
								echo "Din varukorg hard updaterats!";
							}
						}
						else{	//Detta sker om det inte ligger en vara med samma productID i varukorgen!
						
							$sql = "INSERT INTO ShoppingCart (OrderID, ProductID, Quantity)VALUES('" . $row["OrderID"] . "','" . $_GET["prodId"]."','" . $_GET["quantity"]."')";
							$result = $conn->query($sql);
							$_SESSION['orderId'] = $row["OrderID"];
							echo "Din shoppincart är updaterad";
						}
					}
				}
				else{				//För de som inte har någon startad order i databasen
					$sql = "INSERT INTO Orders (AccountID) VALUES ('" . $_SESSION['accID'] . "')";
					$result = $conn->query($sql);
					
					$sql = "SELECT OrderID FROM Orders WHERE AccountID =" . $_SESSION['accID'] . " AND OrderDate IS NULL";
					$result = $conn->query($sql);
					if($result->num_rows > 0){			//Detta är om det redan finns en order tillhörande den användaren i databasen
						if($row = $result->fetch_assoc()) {
							$sql = "INSERT INTO ShoppingCart (OrderID, ProductID, Quantity)VALUES('" . $row["OrderID"] . "','" . $_GET["prodId"]."','" . $_GET["quantity"]."')";
							$_SESSION['orderId'] = $row["OrderID"];
							$result = $conn->query($sql);
						}
					}
					
					
					echo "En orderID har skapats för användaren samt att produkten lagts till";
				}
		}
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
			<input id='quantity' name='quantity' type='number' value='1' min='1' max='".  $row["Quantity"] ."' />
		<input id='prodId' name='prodId' type='hidden' value=" . $row["ProductID"]. "> 
	
		<input type='submit' value='Lägg till' ></form></div>";		//Raden ovan är till för att skicka med vilket produktID. Här någonstans borde vi lägga till så att man kan välja antal.
         //OBS OBS, form validation på serversidan måste ske här
	
    }
	
} else {
    echo "There is no products in the database, please contact admin";
}
$conn->close();
 
 
?>


</div>
</body>
</html>
