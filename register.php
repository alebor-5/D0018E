<?php
	include_once 'extra/header.php';
	
	//Om användaren har fel input
	$fname = "";
	$lname = "";
	$mail = "";
	$uname = "";
	$pwd = "";
	$add = "";
	$zip = "";
	
	if(isset($_GET['fname'])) {
		if($_GET['fname'] == 1){
			$fname = "* Endast bokstäver";
		}
		
		if($_GET['lname'] == 1){
			$lname = "* Endast bokstäver";
		}
		
		if($_GET['mail'] == 1){
			$mail = "* Mailadressen används";
		}
		
		if($_GET['uname'] == 1){
			$uname = "* Användarnamnet är taget";
		}elseif($_GET['uname'] == 2){
			$uname = "* Endast bokstäver & siffror";
		}
		
		if($_GET['add'] == 1){
			$add = "* Endast bokstäver & siffror";
		}
		
		if($_GET['zip'] == 1){
			$zip = "* Endast siffror";
		}
	
	}	
?>

<div id="body-wr" style="text-align: center">
	<form action="extra/registerProcess.php" method="POST">
		<input autofocus="autofocus" onfocus="this.select()" 
		type="text" name="firstName" placeholder="Förnamn">
		<span style="color:red; position:absolute;"> <?php echo $fname; ?></span><br>
		
		<input type="text" name="lastName" placeholder="Efternamn">
		<span style="color:red; position:absolute;"> <?php echo $lname; ?></span><br>
		
		<input type="text" name="email" placeholder="E-mail">
		<span style="color:red; position:absolute;"> <?php echo $mail; ?></span><br>
		
		<input type="text" name="username" placeholder="Användarnamn">
		<span style="color:red; position:absolute;"> <?php echo $uname; ?></span><br>
		
		<input type="password" name="password" placeholder="Lösenord">
		<span style="color:red; position:absolute;"> <?php echo $pwd; ?></span><br>
		
		<input type="text" name="address" placeholder="Adress">
		<span style="color:red; position:absolute;"> <?php echo $add; ?></span><br>
		
		<input type="text" name="zipCode" placeholder="Postnummer">
		<span style="color:red; position:absolute;"> <?php echo $zip; ?></span><br>
		
		<input type="submit" name="submit" value="Registrera">
	</form>
</div>

</body>
</html>