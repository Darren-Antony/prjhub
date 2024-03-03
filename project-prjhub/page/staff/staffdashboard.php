<?php
require_once('../config.php');
session_start();
$user_id = $_SESSION['suser_id'];
 
$slQry2 = "SELECT * FROM guide WHERE U_Id = $user_id";
$slresult2 = mysqli_query($conn, $slQry2) or die(mysqli_error($conn));
$unreadQuery = "SELECT COUNT(*) AS unreadCount FROM notification WHERE receiver_Id = $user_id AND unreadMsg = 0";
$unreadResult = mysqli_query($conn, $unreadQuery);
$unreadRow = mysqli_fetch_assoc($unreadResult);
$unreadCount = $unreadRow['unreadCount'];
$sRow = mysqli_fetch_assoc($slresult2);
$G_Name = $sRow['G_Name'];
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
    <link rel="stylesheet" href="../../style/dashboard/staffdb.css">
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../script/staff/dashboard/dashboard.js"></script>
    <script src="../../script/global.js"></script>
    <script src="../../dependancies/sweetalert.js"></script>
    <title>dashboard</title>
</head>

<body >
<div class="logo-cont">
    <div class="logo">
    <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
        
        <div class="right">
       <button class='blue-btn' onclick="StudentPage()">Student</button> 
       
       <div class="notif-cont">
         <button onclick="notif()"><img src="<?php echo $unreadCount > 0 ? '../../asset/image/notification (1).png' : '../../asset/image/notification.png' ?>"></button>
       </div>
       
       <div class="user-cont">
         <button class="User" onclick="toggleDropdown()"><img src="../../asset/image/user.png" alt="" srcset=""></button>
       </div>
       
       <div class="dropdown-menu" id="dropdownMenu">
       <span class="username">Hi <?php echo  $sRow['G_Name']?></span><br>
            <a href="./StupersonalDetail.php">Personal Details</a><br>
            <a href="change-password">Change Password</a><br>
            <a href="#"  onclick="confirmLogout(event)">Logout</a><br>
        </div>
    </div>
    </div>

<?php

$guideQuery = "SELECT * FROM guide WHERE U_Id = '$user_id'";
$guideRes = mysqli_query($conn, $guideQuery);
$guideRow = mysqli_fetch_assoc($guideRes);
$guide_Id = $guideRow['Guide_Id'];

$stuQuery = "SELECT * FROM project WHERE Guide_Id = '$guide_Id' AND Prj_Status = 'pending-approval' or Prj_Status='In-progress'";
$stuRes = mysqli_query($conn, $stuQuery);

?>
<div class="main-prj-cont">
<?php
if (mysqli_num_rows($stuRes) > 0) {
    while ($stuRow = mysqli_fetch_assoc($stuRes)) {
        echo '<div class="inner-prj-cont">';
        echo $stuRow['Prj_Name']; 

        echo '<button class="blue-btn" onclick="viewPrj(' . $stuRow['Prj_Id'] . ')">View</button>';
        echo '</div>';
    }
} else {
    echo 'No projects found.';
}
?>
  </div>
 
<script>
    function viewPrj(prjId) {
        console.log('Clicked on View button. Project ID:', prjId);
        window.open('../../../../../prjhub/project-prjhub/Backend/staff/viewPrj.php?prjId=' + prjId, '_blank');
    }
    function notif(){
        window.location.href="./staffNotif.php";
    }
</script>

</body>

</html>