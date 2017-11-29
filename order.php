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

//if(isset($_GET['account'])) {

if(isset($_SESSION['user'])) {		//För iinloggade
	if(isset($_GET['account'])) {


		$datetime = date_create()->format('Y-m-d H:i:s'); //Hämta tiden från server och använd denna som orderdate
		$sql = "UPDATE Orders SET OrderDate='". $datetime . "' WHERE OrderID= '" . $_SESSION['orderId'] .  "'";

		if ($conn->query($sql) === TRUE) {
			$tempOrderID = $_SESSION['orderId'];
			$ordered = True;
		 	echo "Din order är nu betald";
		}
		else{
			echo "Något gick snett, kontakta admin";
		}
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
		$datetime = date_create()->format('Y-m-d H:i:s'); //Hämta tiden från server och använd denna som orderdate
		$sql = "INSERT INTO Orders( FirstName,LastName,Email,Address,ZipCode,OrderDate)
		VALUES ('".$_SESSION['fname']."','".$_SESSION['lname'] ."','".$_SESSION['mail']."','".$_SESSION['add']."','".$_SESSION['zip']."','".$datetime ."')";

		if ($conn->query($sql) === TRUE) {
			$tempOrderID = $conn->insert_id;
		    echo "Din order är nu betald";

				//Hitta vilket orderID som skapats för att kunna koppla detta till en ShoppingCart





				//följande är om ordern har lagts in skall även shoppingcarten laddas upp i databasen!
				if(isset($_SESSION['prodIDs'])){


					foreach($_SESSION['prodIDs'] as $tempId => $quant){


						$sql = "INSERT INTO ShoppingCart(OrderID,ProductID,Quantity)
						VALUES ('".$tempOrderID."','".$tempId."','".$quant."')";
						$result = $conn->query($sql);
					//Slut på inläggning i ShoppingCart
					}
				}
			}
		else {
		    echo "Error: " . $sql . "<br>" . $conn->error . ". Please contact admin!";
		}
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
				echo '<input type="submit" name="account" value="Beställ">';
			}
			else{
				echo '<input type="submit" name="guest" value="Beställ">';
			}
		?>
	</form>

	<?php
		if($ordered){
			$ordered = False;
			echo '<div class="alert">
					Tack för din beställning<br>
					Ditt orderID är: '. $tempOrderID . '<br>
					<a href="index.php"><span class="closebtn">Tillbaks Till Startsidan</span></a>
				</div>';
		}
	?>
</div>
</body>
</html>
