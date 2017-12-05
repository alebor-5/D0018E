<?php
	if(!isset($_SESSION["user"]) || !($_SESSION["user"] == 0) ){
			header("Location: index.php");
	}

?>