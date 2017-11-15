
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

<form action="additem.php" method="post">
	Name:<br>
	<input type="text" name="name" /><br>
	Quantity:<br>
	<input type="text" name="quantity" /><br>
	Height:<br>
	<input type="text" name="height" /><br>
	Weight:<br>
	<input type="text" name="weight" /><br>
	Cost:<br>
	<input type="text" name="cost" /><br>
	<input type="submit" value="Submit" />
</form>

</div>
</body>
</html>