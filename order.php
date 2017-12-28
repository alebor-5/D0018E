<?php

include_once 'extra/header.php';
include_once 'extra/conn.php';

//Första för invalid input varning, andra för autofill för konton
$fname = $fname2 = "";
$lname = $lname2 = "";
$mail = $mail2 = "";
$add = $add2 = "";
$zip = $zip2 = "";

$ordered = False;
$errPrint = "";

$invCost;

if(isset($_SESSION['user'])) {		//För inloggade
	if(isset($_GET['account'])) {
		$ordered = True;
	}

	$fname2 = $_SESSION['fname'];
	$lname2 = $_SESSION['lname'];
	$mail2 = $_SESSION['mail'];
	$add2 = $_SESSION['add'];;
	$zip2 = $_SESSION['zip'];

}
else{//ej konto
	if(isset($_GET['fname'])) {//något input var invalid
		if($_GET['fname'] == 1){
			$fname = "* Endast bokstäver";
		}

		if($_GET['lname'] == 1){
			$lname = "* Endast bokstäver";
		}

		if($_GET['mail'] == 1){
			$mail = "* Mailadressen används";
		}

		if($_GET['add'] == 1){
			$add = "* Endast bokstäver & siffror";
		}

		if($_GET['zip'] == 1){
			$zip = "* Endast siffror";
		}
	}
	elseif(isset($_GET['guest'])) {			//Detta är för icke inloggade
		$ordered = True;

	}


	//valid information is displayed
	if(isset($_SESSION['fname'])) {
		$fname2 = $_SESSION['fname'];
	}
	if(isset($_SESSION['lname'])) {
		$lname2 = $_SESSION['lname'];
	}
	if(isset($_SESSION['mail'])) {
		$mail2 = $_SESSION['mail'];
	}
	if(isset($_SESSION['add'])) {
		$add2 = $_SESSION['add'];
	}
	if(isset($_SESSION['zip'])) {
		$zip2 = $_SESSION['zip'];
	}
}
?>
<div id="body-wr" style="text-align: center">
<?php
$summa = 0;
$totalquantity = 0;

if(!isset($_SESSION['user'])){ //Detta är för icke inloggade användare!
	if(isset($_SESSION['prodIDs'])){

		if(empty($_SESSION['prodIDs'])){	//sker när icke-inloggad användare är i korgen men den är tom. Om inget echo sker så blir det en ful glipa
			echo "Det finns inga produkter i din varukorg";
		}
		else{
			echo "Din beställning";	//Måste ha den, annars blir det glipa.. vet ej varför
		}

		foreach($_SESSION['prodIDs'] as $tempId => $quant){


			$sql = "SELECT Cost FROM Inventory WHERE ProductID=" . $tempId  . "";
			$result = $conn->query($sql);

			while($row = $result->fetch_assoc()) {
				$invCost[$tempId] = $row["Cost"];	//Sparar det nuvarande priset
				$summa += $quant * $row["Cost"];
				$totalquantity += $quant;
			}
		}
	}
	else{
		echo "Det finns inga produkter i din varukorg";
	}
}

if(isset($_SESSION['user']) && isset($_SESSION['orderId'])){		//För inloggade

	$sql = "SELECT OrderItems.ProductID, Inventory.name, Inventory.URL, OrderItems.Quantity, Inventory.Cost FROM OrderItems INNER JOIN Inventory ON OrderItems.productID = Inventory.productID WHERE OrderID =" . $_SESSION['orderId'] . "";
	$result = $conn->query($sql);
	$_SESSION['userQuant'] = 0;
	if ($result->num_rows > 0) {
		echo "Din beställning";

		while($row = $result->fetch_assoc()) {
			$invCost[$row["ProductID"]] = $row["Cost"];		//Sparar undan det nuvarande priset för varje produkt
			$summa = $summa + $row["Cost"] * $row["Quantity"];
			$totalquantity += $row["Quantity"];
		}
	}else {
		echo "Det finns inga produkter i din varukorg";
	}
	$_SESSION['userQuant'] = $totalquantity;
}
?>
	<div id='cartsummary'>
		<p style="text-align:right;margin-right:100px;">Antal:<b> <?php echo $totalquantity; ?> st</b></p>
		<p style="text-align:right;margin-right:100px;">Summa:<b> <?php echo $summa; ?> kr</b></p>
	</div>


<!--<div id="body-wr" style="text-align: center">-->
	<form action="extra/orderProcess.php" method="POST">
		<input type="text" name="firstName" placeholder="Förnamn" value="<?php echo $fname2; ?>">
		<span style="color:red; position:absolute;"> <?php echo $fname; ?></span><br>

		<input type="text" name="lastName" placeholder="Efternamn" value="<?php echo $lname2; ?>">
		<span style="color:red; position:absolute;"> <?php echo $lname; ?></span><br>

		<input type="text" name="email" placeholder="E-mail" value="<?php echo $mail2; ?>">
		<span style="color:red; position:absolute;"> <?php echo $mail; ?></span><br>

		<input type="text" name="address" placeholder="Adress" value="<?php echo $add2; ?>">
		<span style="color:red; position:absolute;"> <?php echo $add; ?></span><br>

		<input type="text" name="zipCode" placeholder="Postnummer" value="<?php echo $zip2; ?>">
		<span style="color:red; position:absolute;"> <?php echo $zip; ?></span><br>

		<?php
			if(isset($_SESSION['user'])) {
				echo '<input type="submit" name="account" value="Beställ" style="display:inline-block">';
			}
			else{
				echo '<input type="submit" name="guest" value="Beställ" style="display:inline-block">';
			}
		?>
	</form>

	<?php
		if($ordered){

			$ordered = False;

			if(isset($_SESSION['user'])){	//Inloggad -----------------------------------------------------------
				$sql = "SELECT ProductID, Quantity FROM OrderItems WHERE OrderID=" . $_SESSION['orderId'] . "";
				$result = $conn->query($sql);



				if($result->num_rows > 0){ //Produkter i korgen för inloggad
					while($row = $result->fetch_assoc()) {
						$sql2 = "SELECT ProductID, Name, Quantity  FROM Inventory WHERE ProductID=" . $row['ProductID'] . "";
						$result2 = $conn->query($sql2);

						if($row2 = $result2->fetch_assoc()) {
							if($row['Quantity'] > $row2['Quantity']){ //Användaren vill beställa mer än det som existerar
								$errPrint .= "Du försöker beställa " . $row['Quantity'] . " " . $row2['Name'] . " men det finns endast " . $row2['Quantity'] . "<br>";
							}
						}
					}
					if(strlen($errPrint) > 0){
						$errPrint .= "Ändra antal i varukorgen eller vänta tills rätt mängd finns";
					}
					//Slut på kollen!

						//Detta uppdaterar lagret så att det blir rätt antal!
						$sql = "SELECT ProductID, Quantity FROM OrderItems WHERE OrderID=" . $_SESSION['orderId'] . "";
						$result = $conn->query($sql);
						$products = array();
						$quantity = array();
					try{//TRANS
						$conn->query("START TRANSACTION");
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								array_push($products,$row["ProductID"]);
								array_push($quantity,$row["Quantity"]);
							}
						}
						for($t=0;$t<count($products);$t++){
							$sql = "UPDATE Inventory SET Quantity = Quantity - " . $quantity[$t] . "  WHERE productID =" . $products[$t] . "" ;
							$result = $conn->query($sql);
							if(!$result){
								echo "Please contact admin!";
							}

						}

						//Slut på uppdatering av lagret

						$datetime = date_create()->format('Y-m-d H:i:s'); //Hämta tiden från server och använd denna som orderdate
						$sql = "UPDATE Orders SET OrderDate='". $datetime . "' WHERE OrderID= '" . $_SESSION['orderId'] .  "'";
						$conn->query($sql);
						$tempOrderID = $_SESSION['orderId'];
						$conn->query("COMMIT");
					}catch (Exception $e){//TRY TRANS
						$conn->query("ROLLBACK");
					}

					foreach($invCost as $tempId => $cost){	//Sätter priset för produkten vid beställningen
						$sql = "UPDATE OrderItems SET ProductPrice = " . $cost . "  WHERE productID = " . $tempId . " AND OrderID = " . $_SESSION['orderId'] . "";
						$result = $conn->query($sql);
					}

					//Slut på det -------------------------------------------------------------------------------------
				}
				else{	//Inget i korgen för inloggad
					$errPrint = "Din varukorg är tom";
				}
			}
			else{	//Inte inloggad
				if(isset($_SESSION['prodIDs']) && !empty($_SESSION['prodIDs'])){ //Något i korgen för ej-inloggad
					foreach($_SESSION['prodIDs'] as $tempId => $quant){
						$sql = "SELECT ProductID, Name, Quantity  FROM Inventory WHERE ProductID=" . $tempId . "";
						$result = $conn->query($sql);

						if($row = $result->fetch_assoc()) {
							if($quant > $row['Quantity']){ //Användaren vill beställa mer än det som existerar
								$errPrint .= "Du försöker beställa " . $quant . " " . $row['Name'] . " men det finns endast " . $row['Quantity'] . "<br>";
							}
						}
					}
					if(strlen($errPrint) > 0){
						$errPrint .= "Ändra antal i varukorgen eller vänta tills rätt mängd finns";
					}
				}
				else{ //inget i korgen för ej-inloggad
					$errPrint = "Din varukorg är tom";
				}
				if(!strlen($errPrint) > 0){
				//Temp: placera här
				try{//TRANS FÖR ICKE-INLOGGADE, även om detta kollas innan är detta en extra säkerhetsåtergärd
					$conn->query("START TRANSACTION");
					$datetime = date_create()->format('Y-m-d H:i:s'); //Hämta tiden från server och använd denna som orderdate
					$sql = "INSERT INTO Orders( FirstName,LastName,Email,Address,ZipCode,OrderDate)
					VALUES ('".$_SESSION['fname']."','".$_SESSION['lname'] ."','".$_SESSION['mail']."','".$_SESSION['add']."','".$_SESSION['zip']."','".$datetime ."')";

						$conn->query($sql);
						$tempOrderID = $conn->insert_id;



							//Hitta vilket orderID som skapats för att kunna koppla detta till en OrderItems
							//följande är om ordern har lagts in skall även OrderItemsen laddas upp i databasen!
							if(isset($_SESSION['prodIDs'])){


								foreach($_SESSION['prodIDs'] as $tempId => $quant){


									$sql = "INSERT INTO OrderItems(OrderID,ProductID,Quantity,ProductPrice)
									VALUES ('".$tempOrderID."','".$tempId."','".$quant."','".$invCost[$tempId]."')";
									$result = $conn->query($sql);
									//Slut på inläggning i OrderItems

									//Följande uppdaterar lagrets antal!
									$sql = "UPDATE Inventory SET Quantity = Quantity - " . $quant . "  WHERE productID = " . $tempId . "" ;
									$result = $conn->query($sql);
									if(!$result){
										echo "Please contact admin!";
									}
									//Slut på uppdatering av lager
								}
							}
						$conn->query("COMMIT");
				}catch (Exception $e){
					$conn->query("ROLLBACK");

				}
				}
			}

			if(strlen($errPrint) > 0){
				echo '<div class="errAlert">
					Ett fel har uppstått med beställningen<br>
					' . $errPrint . '<br>
					<a href="OrderItems.php"><span class="closebtn">Tillbaks Till Varukorgen</span></a>
				</div>';
			}
			else{
				//Tömmer varukorg
				if(isset($_SESSION["user"])){	//För inloggade
					$sql = "INSERT INTO Orders (AccountID) VALUES ('" . $_SESSION['accID'] . "')";
					if ($conn->query($sql) === TRUE) {
						$sql = "SELECT OrderID FROM Orders WHERE AccountID =" . $_SESSION['accID'] . " AND OrderDate IS NULL";
						$result = $conn->query($sql);

						if($result->num_rows > 0){
							if($row = $result->fetch_assoc()) {
								$_SESSION['orderId'] = $row["OrderID"];
							}
						}
						$_SESSION['userQuant'] = 0;
					}
					else {
						echo "Error: varukorgen tömdes ej " . $conn->error;
					}
				}
				else{	//För icke inloggade
					unset($_SESSION['prodIDs']);
				}


				echo '<div class="alert">
					Tack för din beställning<br>
					Ditt orderID är: '. $tempOrderID . '<br>
					<a href="index.php"><span class="closebtn">Tillbaks Till Startsidan</span></a>
				</div>';
			}
			//echo "</form>";
		}
	?>
</div>
</body>
</html>
