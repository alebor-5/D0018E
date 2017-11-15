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
<!-- behöver kolla så admin konto aktiverat -->

<?php

$sql = "INSERT INTO Inventory ( Name, Quantity, Height, Weight, Cost)
VALUES ('".$_POST["name"]."','".$_POST["quantity"]."','".$_POST["height"]."','".$_POST["weight"]."','".$_POST["cost"]."')";

if ($conn->query($sql) === TRUE) {
    echo "New product is inserted into the database";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . ". Please contact admin!";
}
 
$conn->close();
?>


</div>
</body>
</html>