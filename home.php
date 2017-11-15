<?php

$servername = "utbweb.its.ltu.se";
$username = "alebor-5";
$password = "hejsan123";
$dbname = "alebor5db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>

<html>
<head>
<title>Test</title>
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>

<body>
<div id="top-wr">
	<img src="img/logga.png" alt="Logga" />
	
	<form action="search_prod.php">
		<input type="text" name="Search" placeholder="Sök produkt" />
		<input type="submit" value="Sök" />
	</form>
	
	<div id="accountandcart">
		<a href="" ><img src="img/account.png" alt="Användare" /></a>
		<a href=""><img src="img/kundvagn.png" alt="Kundvagn" id="temp" /></a>
	</div>
</div>

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