<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	include_once 'extra/admincheck.php';
	?>
<div id="body-wr">


<?php
$conn->query("SET NAMES utf8");
$sql = "INSERT INTO Inventory ( Name, Quantity, Height, Weight, Cost, Description, URL)
VALUES ('".$_POST["name"]."','".$_POST["quantity"]."','".$_POST["height"]."','".$_POST["weight"]."','".$_POST["cost"]."','". $_POST["description"] . "','" . $_POST["url"] . "')";

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
