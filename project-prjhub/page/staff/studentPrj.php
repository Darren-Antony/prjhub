<?php
require_once('../config.php');
session_start();
$user_id = $_SESSION['suser_id'];
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
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../script/staff/dashboard/dashboard.js"></script>
    
    <title>dashboard</title>
</head>

<body >
<div class="logo-cont">
        <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
        <button class='blue-btn' onclick="StudentPage()">Student</button> 
    </div>

<?php

$guideQuery = "SELECT * FROM guide WHERE U_Id = '$user_id'";
$guideRes = mysqli_query($conn, $guideQuery);
$guideRow = mysqli_fetch_assoc($guideRes);
$guide_Id = $guideRow['Guide_Id'];

$stuQuery = "SELECT * FROM project WHERE Guide_Id = '$guide_Id' AND Prj_Status = 'pending-approval'";
$stuRes = mysqli_query($conn, $stuQuery);

if (mysqli_num_rows($stuRes) > 0) {
    while ($stuRow = mysqli_fetch_assoc($stuRes)) {
        echo '<div class="project-details">';
        echo $stuRow['Prj_Name']; 
        echo '<button class="blue-btn" onclick="viewPrj(' . $stuRow['Prj_Id'] . ')">View</button>';
        echo '</div>';
    }
} else {
    echo 'No projects found.';
}


 
 
?>
  <script>
    function viewPrj(prjId){
        $.ajax({
            url:'../../Backend/staff/viewPrj.php',
            method:'POST',
            data:{prjId:prjId},
            success:function(response){
                console.log('viewPrj request is succesfully sent')
            },
            error:function(xhr,status,error){
                alert('Error : ' + error);
            }
        })
    }
  </script>


</body>

</html>