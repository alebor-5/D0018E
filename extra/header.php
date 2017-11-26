<?php
	session_start();
?>


<html>
<head>
<title>Test</title>
<link rel="stylesheet" type="text/css" href="style/main.css" />
</head>

<body>
<div id="top-wr">
	<!--<img src="img/logga.png" alt="Logga" />-->
	<a href="index.php"><img src="img/logga.png" alt="Logga" /></a>
	
	<form action="search_prod.php">
		<input type="text" name="Search" placeholder="Sök produkt" />
		<input type="submit" value="Sök" />
	</form>
	
	<div id="accountandcart">
			
		<div class="dropdown">
			<a href="" ><img src="img/account.png" alt="Användare" /></a>
			<div class="dropdown-content">	
				<?php
					if(isset($_SESSION['user'])){
						if($_SESSION['user'] == 0){
							echo '<a href="login.php" >Korg</a><br>
							<a href="extra/logout.php" >Logga ut</a>';
						}elseif($_SESSION['user'] == 1){
							echo '<a href="login.php" >AdminGrejer</a><br>
							<a href="extra/logout.php" >Logga ut</a>';
						}						
					} else{
						echo '<a href="login.php" >Logga in</a><br>
						<a href="register.php" >Registrera</a>';
					}
				?>	
				
				
			</div>
		</div>
		
		
		
		<a href=""><img src="img/kundvagn.png" alt="Kundvagn" id="temp" /></a>
	</div>
</div>