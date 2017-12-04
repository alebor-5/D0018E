<?php
	if(!isset($_SESSION["user"]) || !($_SESSION["user"] == 1) ){
			header("Location: index.php");
	}

?>