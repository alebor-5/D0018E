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



function getRating ($pID){
  global $conn;
  $sql = "SELECT Rating FROM Comments WHERE ProductID=" . $pID  . "";
  $result = $conn->query($sql);
  $counts = 0;
  $totalRating = 0;
  $Rating = 0;


  while($row = $result->fetch_assoc()) {
	if($row["Rating"] > 0){ //Endast ratings mellan 1-5 används för räkna medelvärde. Användare som inte lämna något rating har inte "ratat".
		$counts++;  
	}
	$totalRating += $row["Rating"];
  }
  if($counts==0){
    $Rating = 0;
  }
  else{
    $Rating = round($totalRating/$counts);
  }
  return $Rating;
}

function writeRating($pID){
  global $conn;
  $Rating = getRating($pID); 
  switch ($Rating){
    case 1:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star uncheckedstar"></span>
    <span id="star3s" class="fa fa-star uncheckedstar" ></span>
    <span id="star4s" class="fa fa-star uncheckedstar" ></span>
    <span id="star5s" class="fa fa-star uncheckedstar" ></span>';
    break;

    case 2:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star checkedstar"></span>
    <span id="star3s" class="fa fa-star uncheckedstar" ></span>
    <span id="star4s" class="fa fa-star uncheckedstar" ></span>
    <span id="star5s" class="fa fa-star uncheckedstar" ></span>';
    break;

    case 3:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star checkedstar"></span>
    <span id="star3s" class="fa fa-star checkedstar" ></span>
    <span id="star4s" class="fa fa-star uncheckedstar" ></span>
    <span id="star5s" class="fa fa-star uncheckedstar" ></span>';
    break;

    case 4:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star checkedstar"></span>
    <span id="star3s" class="fa fa-star checkedstar" ></span>
    <span id="star4s" class="fa fa-star checkedstar" ></span>
    <span id="star5s" class="fa fa-star uncheckedstar" ></span>';
    break;

    case 5:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star checkedstar"></span>
    <span id="star3s" class="fa fa-star checkedstar"></span>
    <span id="star4s" class="fa fa-star checkedstar" ></span>
    <span id="star5s" class="fa fa-star checkedstar" ></span>';
    break;

    default:
    return '<span id="star1s" class="fa fa-star uncheckedstar"></span>
    <span id="star2s" class="fa fa-star uncheckedstar"></span>
    <span id="star3s" class="fa fa-star uncheckedstar"></span>
    <span id="star4s" class="fa fa-star uncheckedstar" ></span>
    <span id="star5s" class="fa fa-star uncheckedstar" ></span>';
    break;
  }
}

function reviewRating($rating){
  switch ($rating){
    case 1:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star uncheckedstar"></span>
    <span id="star3s" class="fa fa-star uncheckedstar" ></span>
    <span id="star4s" class="fa fa-star uncheckedstar" ></span>
    <span id="star5s" class="fa fa-star uncheckedstar" ></span>';
    break;

    case 2:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star checkedstar"></span>
    <span id="star3s" class="fa fa-star uncheckedstar" ></span>
    <span id="star4s" class="fa fa-star uncheckedstar" ></span>
    <span id="star5s" class="fa fa-star uncheckedstar" ></span>';
    break;

    case 3:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star checkedstar"></span>
    <span id="star3s" class="fa fa-star checkedstar" ></span>
    <span id="star4s" class="fa fa-star uncheckedstar" ></span>
    <span id="star5s" class="fa fa-star uncheckedstar" ></span>';
    break;

    case 4:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star checkedstar"></span>
    <span id="star3s" class="fa fa-star checkedstar" ></span>
    <span id="star4s" class="fa fa-star checkedstar" ></span>
    <span id="star5s" class="fa fa-star uncheckedstar" ></span>';
    break;

    case 5:
    return '<span id="star1s" class="fa fa-star checkedstar"></span>
    <span id="star2s" class="fa fa-star checkedstar"></span>
    <span id="star3s" class="fa fa-star checkedstar"></span>
    <span id="star4s" class="fa fa-star checkedstar" ></span>
    <span id="star5s" class="fa fa-star checkedstar" ></span>';
    break;

  }
}





?>
