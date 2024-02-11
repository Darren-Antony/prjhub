<?php
require_once('../config.php');
session_start();
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/dashboard.css">
    <link rel="stylesheet" href="../../style/dashboard/stdashboard.css">

    
    <title>dashboard</title>
</head>

<body >
<div class="logo-cont">
        <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>

<?php
$guideQuery = "SELECT * FROM guide WHERE U_Id = '$user_id'";
$guideRes = mysqli_query($conn, $guideQuery);
$guideRow = mysqli_fetch_assoc($guideRes);
$guide_Id = $guideRow['Guide_Id'];

$stuQuery = "SELECT * FROM student WHERE Guide_Id = '$guide_Id'";
$stuRes = mysqli_query($conn, $stuQuery);

if (mysqli_num_rows($stuRes) > 0) {
    echo '<div class="student-details">';
   
    echo'<table class="student-tbl">';
    echo "<thead>";
    echo "<tr>";
    echo "<th>Dept No</th>";
    echo "<th>Name</th>";
    echo "<th>Degree</th>";
    echo "<th>Submission History</th>";
    echo "</tr>";
    echo "</thead>";
    while ($stuRow = mysqli_fetch_assoc($stuRes)) {
        
        
// Assuming $stuRow is an associative array containing student data
echo "<tr>";
echo "<td>" . $stuRow['Dept_No'] . "</td>";
echo "<td>" . $stuRow['Stu_Name'] . "</td>";
echo "<td>" . $stuRow['Degree'] . "</td>";
echo '<td><button class="blue-btn" id="' . $stuRow['Dept_No'] . '" onclick=viewHistory(this.id)">view</td>';
echo "</tr>";
}




    echo'</table>';
    echo '</div>';
    echo '</div>';
} else {
    echo 'No students found.';
}

 
 
?>
  


</body>

</html>