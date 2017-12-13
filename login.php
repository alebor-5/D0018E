<?php

	include_once 'extra/header.php';
	
	//Om användaren har fel input
	$uname = "";
	$pwd = "";
	
	if(isset($_GET['uname'])) {
		if($_GET['uname'] == 1){
			$uname = "* Användarnamnet finns inte";
		}
		
		if($_GET['pwd'] == 1){
			$pwd = "* Fel lösenord";
		}
	}
?>

<div id="body-wr" style="text-align: center">
	<form action="extra/loginProcess.php" method="POST">
	
		<input autofocus="autofocus" onfocus="this.select()" 
		type="text" name="username" placeholder="Användarnamn">
		<span style="color:red; position:absolute;"> <?php echo $uname; ?></span><br>
		
		<input type="password" name="password" placeholder="Lösenord">
		<span style="color:red; position:absolute;"> <?php echo $pwd; ?></span><br>
		
		<input type="submit" name="submit" value="Logga in">
	</form>
</div>

</body>
</html>