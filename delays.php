<?php

//Check how to connect to the database via php. Authenticate to the DB
$serverName = "localhost";

$userName = "root";

$password = "";

$dbName = "students verification";

//create connection

$con = mysqli_connect($serverName, $userName, $password, $dbName);

if (mysqli_connect_errno()) {
    echo "Failed to connect!";
    exit();

}
echo "Connection success!";
//Change from arduino
$CheckInTime = '08:05:00';
$StartingTime = '08:00:00';

//Once connected, check how to select students from the students_inf table
$sql = "SELECT * FROM `student_inf` WHERE Chip_ID = '45 18 41 C5'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $Student_ID = $row["student_id"];
    $First_name = $row["First_name"];
    $Last_name = $row["Last_name"];
    $Class = $row["Class"];
}
}else {
  echo "0 results";
}

//Add logic to see if a student is late
if (strtotime($CheckInTime) > strtotime($StartingTime)) {
    echo "<br>Late";

    //TO DO: CHECK THIS ONE AND REMOVE THE TMP SOLUTION
    $diffrence = strtotime($CheckInTime) - strtotime($StartingTime) - strtotime( '02:00:00' ) ;
    echo date(' H:i:s',$diffrence);
}
else{
    echo "<br >Not late";
}
$insertSQL = "INSERT INTO `delays`(`delay_id`, `first_name`, `last_name`, `class`) VALUES (`1`,)";

if (mysqli_query($con, $insertSQL)) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
  }

  mysqli_close($con);

//If student is late, insert into delays table
//Important items: use echo to print data

//Add ddate to the delays, make sure you add the date the user has delayed, pull delayed users for the specific date