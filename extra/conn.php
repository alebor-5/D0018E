<?php
$servername = "utbweb.its.ltu.se";
$username = "antwah-5";
$password = "hejsan123";
$dbname = "antwah5db";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>