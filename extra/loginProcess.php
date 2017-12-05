<?php

session_start();

if (isset($_POST['submit'])){
	
	include_once 'conn.php';
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	
	//Error handlers
	
	$sql = "SELECT * FROM Account WHERE Username='$username'";	
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		//Username exist
		$uname = "uname=0&";				
		
	}
	else{
		//Wrong username
		$uname = "uname=1&";
	}
	
	$row = $result->fetch_assoc();
	
	if(password_verify($password,$row["Pwd"])){
		//login success
		$_SESSION['user'] = $row['Admin'];
		$_SESSION['accID'] = $row['AccountID'];
		
		$_SESSION['fname'] = $row['FirstName'];
		$_SESSION['lname'] = $row['LastName'];
		$_SESSION['mail'] = $row['Email'];
		$_SESSION['add'] = $row['Address'];
		$_SESSION['zip'] = $row['ZipCode'];
		
		$sql = "SELECT OrderID FROM Orders WHERE AccountID =" . $_SESSION['accID'] . " AND OrderDate IS NULL";
		$result = $conn->query($sql); 
		
		if($result->num_rows > 0){
			if($row = $result->fetch_assoc()) {
				$_SESSION['orderId'] = $row["OrderID"];
			}
		}
				
		$pwd = "pwd=0";		
		header("Location: ../index.php");
		exit();
		
	} else{
		//Wrong password
		if($uname === "uname=0&"){
			$pwd = "pwd=1";	//Only shows wrong password if username is correct
		}
		else{
			$pwd = "pwd=0";
		}	
	}
	
	header("Location: ../login.php?$uname$pwd");
	exit();
	
} else {
	header("Location: ../login.php?AjaBaja");
	exit();
}