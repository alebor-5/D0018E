
<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
?>

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