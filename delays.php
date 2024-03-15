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
echo '<div style="display: flex">
<img src="https://elsys-bg.org/web/images/logo.svg" style="margin-RIGHT: 30px;">
<h1 class="white-font"> <font size="40"> TUES delays </font> </h1>
    
</div>';

echo '<p class="white-font">  <font size="29"> These students are late! </font> </p>';

echo '<table>';
echo "<tr>
<th class='white-font_colum1'>Sudent's name</th>
<th class='white-font_colum2'>Class</th>
<th class='white-font_colum3'>Date</th>
</tr>";

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    $First_name = $row["first_name"];
    $Last_name = $row["last_name"];
    $Class = $row["class"];
    $Todays_date = $row["todays_date"];
    echo "<tr>
    <td class='white-font_colum1'>".$First_name. " ".$Last_name."</td>
    <td class='white-font_colum2'>".$Class."</td>
    <td class='white-font_colum3'>".$Todays_date."</td>
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
color: black;
}
.white-font{
color: white;
}
.white-font_colum1{
color: white;
width: 250px;
}
.white-font_colum2{
color: white;
width: 70px;
}
.white-font_colum3{
color: white;
width: 150px;
}
.yellow-font{
color: yellow;
}

table, th, td {
  border:1px solid white;
}
body{
  background: url(https://i.pngimg.me/thumb/f/720/b8c1a31c41e24e369c1a.jpg);
  background-repeat: repeat;
  background-size: cover;
  height:100dvh;
}
</style>