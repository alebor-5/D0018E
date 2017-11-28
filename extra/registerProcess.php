<?php

if (isset($_POST['submit'])){
	
	include_once 'conn.php';
	
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$address = $_POST['address'];
	$zipCode = $_POST['zipCode'];
	$admin = 0;
	
	
	$invalid = 0; //check input faults
	
	//Error handlers
	if(preg_match("/[^A-Za-zÅÄÖåäö]/", $firstName) or strlen($firstName) == 0){
		//invalid characters
		$fname = "fname=1&";
		$invalid++;
	}
	else{
		$fname = "fname=0&";
	}
	
	if(preg_match("/[^A-Za-zÅÄÖåäö]/", $lastName) or strlen($lastName) == 0){
		//invalid characters
		$lname = "lname=1&";
		$invalid++;
	}
	else{
		$lname = "lname=0&";
	}
	
	$sql = "SELECT * FROM Account WHERE Email='$email'";	
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 or strlen($email) == 0) {
		$mail = "mail=1&";
		$invalid++;
	}
	else{
		$mail = "mail=0&";
	}

	
	$sql = "SELECT * FROM Account WHERE Username='$username'";	
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 or strlen($lastName) == 0) {
		//Username taken
		$uname = "uname=1&";
		$invalid++;
		
	}
	elseif(preg_match("/[^A-Za-z0-9ÅÄÖåäö]/", $username) or strlen($lastName) == 0){
		//invalid characters
		$uname = "uname=2&";
		$invalid++;
	}
	else{
		$uname = "uname=0&";
	}
	
	if(preg_match("/[^A-Za-z0-9ÅÄÖåäö]/", $address) or strlen($address) == 0){
		//invalid characters
		$add = "add=1&";
		$invalid++;
	}
	else{
		$_SESSION['add'] = $address;
		$add = "add=0&";
	}
	
	if(preg_match("/[^0-9]/", $zipCode) or strlen($lastName) == 0){
		//invalid characters
		$zip = "zip=1";
		$invalid++;
	}
	else{
		$zip = "zip=0";
	}
	
	if($invalid > 0){
		header("Location: ../register.php?$fname$lname$mail$uname$add$zip");
		exit();
	}
	
	//Valid input	
	$sql = "INSERT INTO Account (FirstName, LastName, Username, Pwd, Address, ZipCode, Email, Admin) VALUES ('$firstName', '$lastName', '$username', '$password', '$address', '$zipCode', '$email', '$admin' );";
	if ($conn->query($sql) == TRUE){
		header("Location: ../index.php?success");
	} else {
		header("Location: ../register.php?failure");
	}
	exit();
	
} else {
	header("Location: ../register.php?AjaBaja");
	exit();
}