<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div id="body-wr">
<div id="indexTopPlacer">
<div></div>		<!-- Just to get margin! -->
<div>Namn</div>
<div>Pris</div>
<div>Antal i lager</div>
<div>Betyg</div>
</div>

<?php
	error_reporting(E_ALL);
	ini_set('display_errors',1);

	//Följande är för att lägg in i OrderItems,
	if (isset($_POST["prodId"]) && isset($_POST["quantity"]) ){
		if(!isset($_SESSION['user'])){
			if(!isset($_SESSION['prodIDs'][$_POST["prodId"]])){		//dessa if else satserna är för icke inloggade!!!

				$_SESSION['prodIDs'][$_POST["prodId"]] =  $_POST["quantity"];
			}
			else{
				$_SESSION['prodIDs'][$_POST["prodId"]] +=  $_POST["quantity"];
			}
		}
		else{ //Dessa är för de inloggade!
			$sql = "SELECT OrderID FROM Orders WHERE AccountID =" . $_SESSION['accID'] . " AND OrderDate IS NULL"; //Nu skapas en ny order istället för att den gammla ersätts
			$result = $conn->query($sql);

				if($result->num_rows > 0){			//Detta är om det redan finns en order tillhörande den användaren i databasen
					if($row = $result->fetch_assoc()) {
						$_SESSION['orderId'] = $row["OrderID"];

						$sql = "SELECT productID FROM OrderItems WHERE OrderID = " . $_SESSION['orderId'] . " AND ProductID = " . $_POST["prodId"] . "";
						$result = $conn->query($sql);

						if($result->num_rows > 0){	//Detta är om det redan finns en produktID tillhörande den användaren i databasen
							if($row = $result->fetch_assoc()) {

								$sql = "UPDATE OrderItems SET Quantity = Quantity + " . $_POST["quantity"] . "  WHERE productID = " . $_POST["prodId"] . " AND orderID=" . $_SESSION['orderId'] . "" ;

								$result = $conn->query($sql);
								echo "Din varukorg hard updaterats!";
								$_SESSION['userQuant'] += $_POST["quantity"];
							}
						}
						else{	//Detta sker om det inte ligger en vara med samma productID i varukorgen!

							$sql = "INSERT INTO OrderItems (OrderID, ProductID, Quantity)VALUES('" . $row["OrderID"] . "','" . $_POST["prodId"]."','" . $_POST["quantity"]."')";
							$result = $conn->query($sql);
							$_SESSION['userQuant'] += $_POST["quantity"];
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
							$sql = "INSERT INTO OrderItems (OrderID, ProductID, Quantity)VALUES('" . $row["OrderID"] . "','" . $_POST["prodId"]."','" . $_POST["quantity"]."')";
							$_SESSION['orderId'] = $row["OrderID"];
							$result = $conn->query($sql);
						}
					}

					$_SESSION['userQuant'] = $_POST["quantity"];
					echo "En orderID har skapats för användaren samt att produkten lagts till";
				}
		}
		header("Location: index.php");
	}
	//Slut på OrderItems

$sql = "SELECT ProductID, name, Quantity, Cost, URL FROM Inventory WHERE Quantity != 0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
			$filename = $row["URL"];

		echo "<div class='main-placer'><a class='linktoprod' href='product.php?prodId=" . $row['ProductID'] . "'><img src='" . $filename . "' class='smallpic' /> <div class='indexName'>" . $row["name"]. "</div><div class='indexCost'>" . $row["Cost"]. " kr </div> <div class='indexQuantity'>" . $row["Quantity"]. "st</div>
		<div class='indexRating'>".writeRating($row['ProductID'])."</div>	</a>
		<div class='indexForm'><form action='index.php' method='POST'>
			<input id='quantity' name='quantity' type='number' value='1' min='1' max='".  $row["Quantity"] ."' />
		<input id='prodId' name='prodId' type='hidden' value=" . $row["ProductID"]. ">

		<input type='submit' value='Lägg till' ></form></div></div>";		//Raden ovan är till för att skicka med vilket produktID. Här någonstans borde vi lägga till så att man kan välja antal.
         //OBS OBS, form validation på serversidan måste ske här

    }

} else {
    echo "There is no products in the database, please contact admin";
}
$conn->close();


?>
<div class='main-placer'></div>

</div>
</body>
</html>
