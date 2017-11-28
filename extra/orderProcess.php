<?php
session_start();
include_once 'conn.php';

if(isset($_POST['account'])){
	header("Location: ../order.php?account=1");
	exit();
}
elseif (isset($_POST['guest'])){
	
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$zipCode = $_POST['zipCode'];
	
	
	$invalid = 0; //check input faults
	
	//Error handlers
	if(preg_match("/[^A-Za-zÅÄÖåäö]/", $firstName) or strlen($firstName) == 0){
		//invalid characters
		$fname = "fname=1&";
		$invalid++;
	}
	else{
		$_SESSION['fname'] = $firstName;
		$fname = "fname=0&";
	}
	
	if(preg_match("/[^A-Za-zÅÄÖåäö]/", $lastName) or strlen($lastName) == 0){
		//invalid characters
		$lname = "lname=1&";
		$invalid++;
	}
	else{
		$_SESSION['lname'] = $lastName;
		$lname = "lname=0&";
	}
	
	$sql = "SELECT * FROM Account WHERE Email='$email'";	
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0 or strlen($email) == 0) {
		$mail = "mail=1&";
		$invalid++;
	}
	else{
		$_SESSION['mail'] = $email;
		$mail = "mail=0&";
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
	
	if(preg_match("/[^0-9]/", $zipCode) or strlen($zipCode) == 0){
		//invalid characters
		$zip = "zip=1";
		$invalid++;
	}
	else{
		$_SESSION['zip'] = $zipCode;
		$zip = "zip=0";
	}
	
	if($invalid > 0){// Alla inputs är inte valid
		header("Location: ../order.php?$fname$lname$mail$add$zip");
		exit();
	}
	else{// Alla inputs är valid
		header("Location: ../order.php?guest=1");
		exit();
	}
} 
else {
	header("Location: ../index.php?AjaBaja");
	exit();
}