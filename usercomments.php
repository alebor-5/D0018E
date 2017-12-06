<?php
	include_once 'extra/conn.php';
	include_once 'extra/header.php';
	include_once 'extra/usercheck.php';
	
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!--Till stjärnorna -->
<div id="body-wr">



<?php	//Detta laddar in kommentarerna
	$firstTemp = True;
	$conn->query("SET NAMES utf8");		//Denna behövs för att få åäö korrekt!
	$sql = "SELECT Review, Rating FROM Comments WHERE AccountID =" . $_SESSION['accID'] . " AND Comments.Review IS NOT NULL" ;
	$result = $conn->query($sql);
	
	while($row = $result->fetch_assoc()) {			
		if($firstTemp && ($row["Review"] != " ")){
			echo "<div class='FirstReviewBox'><h2>" . $_SESSION['uname']. "</h2><div class='ratingfix'>".reviewRating($row["Rating"])."</div><p class='textcomment'>" .htmlspecialchars( $row["Review"]) . "</p></div>";
			$firstTemp = False;
		}
		else if(($row["Review"] != " ")){
			echo "<div class='ReviewBox'><h2>" . $_SESSION['uname']. "</h2><div class='ratingfix'>".reviewRating($row["Rating"])."</div><p class='textcomment'>" . htmlspecialchars( $row["Review"]) . "</p></div>";
		}		
	}
	if($firstTemp){
		echo "Du har inga recensioner"; 
	}

?>
	

</div>

</div>

<?php

?>
</body>
</html>
