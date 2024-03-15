<?php
//Check how to connect to the database via php. Authenticate to the DB
$serverName = "localhost";

$userName = "root";

$password = "";

$dbName = "students verification";

//create connection

$con = mysqli_connect($serverName, $userName, $password, $dbName);

if (mysqli_connect_errno()) {
    exit();

}
//Change from arduino
$CheckInTime = '08:01:00';
$StartingTime = '08:00:00';
$todays_date = date('d-m-Y');

//Once connected, check how to select students from the students_inf table
$sql = "SELECT * FROM `student_inf` WHERE Chip_ID = '01 02 03 04'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $First_name = $row["First_name"];
    $Last_name = $row["Last_name"];
    $Class = $row["Class"];
}
}else {
  echo "0 results";
}
$is_late = '';
//Add logic to see if a student is late
if (strtotime($CheckInTime) > strtotime($StartingTime)) {
    $is_late = "Late";

    //TO DO: CHECK THIS ONE AND REMOVE THE TMP SOLUTION
    $diffrence = strtotime($CheckInTime) - strtotime($StartingTime) - strtotime( '02:00:00' ) ;
    
    $insertSQL = "INSERT INTO `delays`( `first_name`, `last_name`, `class`, `todays_date`) VALUES ('$First_name','$Last_name','$Class','$todays_date')";
    if (mysqli_query($con, $insertSQL)) {
      } else {
      }
    
    
}
else{
    echo "<br >Not late";
}
//Can add: Where...
$delayed_table = "SELECT * FROM `delays`";
$result = mysqli_query($con, $delayed_table);
echo '<h1 class="red-font"> <font size="45"> Late </font> </h1>';

echo '<p class="black-font">  <font size="29"> These students are late! </font> </p>';

echo '<table>';
echo "<tr>
<th>Sudent's name</th>
<th>Class</th>
<th>Today's date</th>
</tr>";

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    $First_name = $row["first_name"];
    $Last_name = $row["last_name"];
    $Class = $row["class"];
    $Todays_date = $row["todays_date"];
    echo "<tr>
    <td>".$First_name. " ".$Last_name."</td>
    <td>".$Class."</td>
    <td>".$Todays_date."</td>
  </tr>";
}
}else {
  echo "0 results";
}

echo "</table>";

mysqli_close($con);

//If student is late, insert into delays table
//Important items: use echo to print data

//Add ddate to the delays, make sure you add the date the user has delayed, pull delayed users for the specific date

//End of logic
?>


<style>
.red-font {
color: red;
}
.black-font{
colour: black;
}
table, th, td {
  border:1px solid black;
}
</style>