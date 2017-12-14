<?php
	session_start();
	
	//Kolla om det finns en tidigare varukorg?
	if(!isset($_SESSION['prodIDs'])){
		 $_SESSION['prodIDs']= array();
		 
	}
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
		<input type="submit" value="Sök" id="subheaderbtn" />
	</form>
	
	<div id="accountandcart">
			
		<div class="dropdown">
			<a href="" ><img src="img/account.png" alt="Användare" /></a>
			<div class="dropdown-content">	
				<?php
					if(isset($_SESSION['user'])){
						if($_SESSION['user'] == 0){
							echo '<a href="order.php" >Beställ</a><br>
							<a href="mypage.php" >Min sida</a><br>
							<a href="extra/logout.php" >Logga ut</a>';
						}elseif($_SESSION['user'] == 1){
							echo '<a href="admin.php" >Admin</a><br>
							<a href="extra/logout.php" >Logga ut</a>';
						}						
					} else{
						echo '<a href="order.php" >Beställ</a><br>
						<a href="login.php" >Logga in</a><br>
						<a href="register.php" >Registrera</a>';
					}
				?>	
				
				
			</div>
		</div>
		
		
		
		<a href="shoppingcart.php"><img src="img/kundvagn.png" alt="Kundvagn" id="temp" />
		<?php
		
		if(function_exists('getCartQuant')){ 
			getCartQuant(); 
		}
		?>
		</a>
	</div>
</div>