<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	header('Content-type: text/html; charset=utf-8');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
<div id="body-wr">



<?php	//Detta är för rating samt kommentarer
	if(isset($_POST["Comment"]) && isset($_POST["starRating"]) && isset($_SESSION["user"])){
	$conn->query("SET NAMES utf8");
	$sql = "INSERT INTO Comments (Review,Rating,ProductID,AccountID) VALUES ('" . $_POST['Comment'] . "', '". $_POST["starRating"] . "','" . $_GET["prodId"] . "','" . $_SESSION["accID"] . "')";
	$result = $conn->query($sql);
		if($result){			//Detta är om det redan finns en order tillhörande den användaren i databasen
			echo "Tack för din recension!";
		}	
	}
	else if(!isset($_SESSION["user"]) && isset($_POST["Comment"]) && isset($_POST["starRating"])){
		echo "Vänligen logga in för att lägga en recension!";
	}






//Lägger till i varukorg, detta borde läggas i en funktion kanske
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
						
						$sql = "SELECT productID FROM ShoppingCart WHERE OrderID = " . $_SESSION['orderId'] . " AND ProductID = " . $_POST["prodId"] . "";																		
						$result = $conn->query($sql);
						
						if($result->num_rows > 0){	//Detta är om det redan finns en produktID tillhörande den användaren i databasen						
							if($row = $result->fetch_assoc()) {
								
								$sql = "UPDATE ShoppingCart SET Quantity = Quantity + " . $_POST["quantity"] . "  WHERE productID = " . $_POST["prodId"] . " AND orderID=" . $_SESSION['orderId'] . "" ;
								
								$result = $conn->query($sql);
								echo "Din varukorg hard updaterats!";
							}
						}
						else{	//Detta sker om det inte ligger en vara med samma productID i varukorgen!
						
							$sql = "INSERT INTO ShoppingCart (OrderID, ProductID, Quantity)VALUES('" . $row["OrderID"] . "','" . $_POST["prodId"]."','" . $_POST["quantity"]."')";
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
							$sql = "INSERT INTO ShoppingCart (OrderID, ProductID, Quantity)VALUES('" . $row["OrderID"] . "','" . $_POST["prodId"]."','" . $_POST["quantity"]."')";
							$_SESSION['orderId'] = $row["OrderID"];
							$result = $conn->query($sql);
						}
					}
					
					
					echo "En orderID har skapats för användaren samt att produkten lagts till";
				}
		}
	}
//Slut på varukorg insert


	if(isset($_GET["prodId"])){
		
		
		$conn->query("SET NAMES utf8");		//Denna behövs för att få åäö korrekt!
		$sql = "SELECT ProductID, Name, Quantity, Height, Weight, Cost, Description, URL FROM Inventory WHERE ProductID =" . $_GET["prodId"] . "";
		$result = $conn->query($sql);
		if($row = $result->fetch_assoc()) {
			$filename = $row["URL"];
			
			
			
			echo "<div class='productDesc'>

			<img src='". $filename . "' alt='Produktbild' />
			<div class='headerholder'><h1> " . $row["Name"] . " </h1></div>
			<p> " .  $row["Description"] . "</p> 
			<div class='buynowbox'>
			<span> " . $row["Cost"] . " kr</span>
			<form action='product.php?prodId=" . $_GET['prodId'] . "' method='post'>
			<input id='quantity' name='quantity' type='hidden' value='1' />
			<input id='prodId' name='prodId' type='hidden' value=" . $row["ProductID"]. "> 
	
			<input type='submit' value='Lägg till' class='specBuyBtn' ></form> 
			</div> 
			</div>  ";
		}
		else{
			echo "Något gick snett! Kontakta admin!";
		}
	}
	else{
		echo "Något verkar ha gått snett. <a href='index.php' title='Tillbaka till startsidan'>Tillbaka till startsidan</a>";
		
	}


?>

<div id="comments-box">
	<div id="userReview">
			<span id="star1" class="fa fa-star " onclick="check(this.id,this)"></span>
			<span id="star2" class="fa fa-star " onclick="check(this.id,this)"></span>
			<span id="star3" class="fa fa-star " onclick="check(this.id,this)"></span>
			<span id="star4" class="fa fa-star" onclick="check(this.id,this)"></span>
			<span id="star5" class="fa fa-star" onclick="check(this.id,this)"></span>
	<p>Skriv en recension om denna produkten:</p>
	<form action="product.php?prodId=<?php echo $_GET['prodId']; ?>" method="post">
		<textarea rows="4" cols="50"name="Comment"> </textarea>
		<input id="starRating" type="hidden" value="0" name="starRating" />
		<input type="submit" value="Skicka din review" />
	</form>
	
	</div>


</div>

</div>


<script>
	function check(id,elem){
		rating = document.getElementById("starRating");
		//document.write("hej");
			if(id == "star1"){
				document.getElementById('star1').classList.add('checkedstar');
				document.getElementById('star2').classList.remove('checkedstar');
				document.getElementById('star3').classList.remove('checkedstar');
				document.getElementById('star4').classList.remove('checkedstar');
				document.getElementById('star5').classList.remove('checkedstar');
				rating.value = 1;
			}
			else if(id == "star2"){
				document.getElementById('star1').classList.add('checkedstar');
				document.getElementById('star2').classList.add('checkedstar');
				document.getElementById('star3').classList.remove('checkedstar');
				document.getElementById('star4').classList.remove('checkedstar');
				document.getElementById('star5').classList.remove('checkedstar');
				rating.value = 2;
			}
			else if(id == "star3"){
				document.getElementById('star1').classList.add('checkedstar');
				document.getElementById('star2').classList.add('checkedstar');
				document.getElementById('star3').classList.add('checkedstar');
				document.getElementById('star4').classList.remove('checkedstar');
				document.getElementById('star5').classList.remove('checkedstar');
				rating.value = 3;
			}
			else if(id == "star4"){
				document.getElementById('star1').classList.add('checkedstar');
				document.getElementById('star2').classList.add('checkedstar');
				document.getElementById('star3').classList.add('checkedstar');
				document.getElementById('star4').classList.add('checkedstar');
				document.getElementById('star5').classList.remove('checkedstar');
				rating.value = 4;
			}
			else if(id == "star5"){
				document.getElementById('star1').classList.add('checkedstar');
				document.getElementById('star2').classList.add('checkedstar');
				document.getElementById('star3').classList.add('checkedstar');
				document.getElementById('star4').classList.add('checkedstar');
				document.getElementById('star5').classList.add('checkedstar');
				rating.value = 5;
			}
	}

</script>
</body>
</html>