<?php
  require_once('../config.php');
  session_start();
  $user_id = $_SESSION['user_id'];

  $slQry2 = "SELECT * FROM admin WHERE U_Id = $user_id";
  $slresult2 = mysqli_query($conn, $slQry2) or die(mysqli_error($conn));
  
  $sRow = mysqli_fetch_assoc($slresult2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/global.css">
    <link rel="stylesheet" href="../../style/form.css">
    <link rel="stylesheet" href="../../style/dashboard/dashboard.css">
    <title>Student Dashboard</title>
    <script src="../../script/student/dashboard/dashboard.js"></script>
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../script/student/dashboard/ajax/selectingGuideajax.js"></script>
    <script src="../../script/student/dashboard/ajax/submitProjectAjax.js"></script>
    <script src="../../script/global.js"></script>
    <link rel="stylesheet" href="../../style/dashboard/admindb.css">
    <script src="../../dependancies/sweetalert.js"></script>
</head>
<body>'
<div class="logo-cont">
    <div class="logo">
    <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
    <div class="right">
    <div class="notif-cont">
        <button ><img src="../../asset/image/notification.png" alt=""></button>
       </div>
       <div class="user-cont">
        <button class="User" onclick="toggleDropdown()"><img src="../../asset/image/user.png" alt="" srcset=""></button>
       </div>
       <div class="dropdown-menu" id="dropdownMenu">
            <span class="username">Hi <?php echo  $sRow['AD_Name']?></span>
            <a href="./StupersonalDetail.php">Personal Details</a>
            <a href="change-password">Change Password</a>
            <a href="logout" onclick="confirmLogout(event)" >Logout</a>
        </div>
    </div>
</div>
<div class="title">
    Admin Action
</div>
<div class="action-cont">
    <div class="action-duo">
      <div class="action">
        <a href="./registerStaffcsv.php">
        <img src="../../asset/image/a4.png" alt="" srcset="">

        </a>
      </div>
      <div class="action">
        <a href="./registerstaff.php">
        <img src="../../asset/image/a1.png" alt="" srcset="">

        </a>
      </div>
   </div>
   <div class="action-duo">
   <div class="action">
    <a href="../../page/admin/Student.php">
    <img src="../../asset/image/a2.png" alt="" srcset="">

    </a>
</div>
<div class="action">
    <a href="./staff.php">
    <img src="../../asset/image/a3.png" alt="" srcset="">

    </a>
</div>
   </div>
<div class="action-duo">
    <div class="action">
        <a href="../../page/admin/projectlist.php">
            <img src="../../asset/image/a5.png" alt="" srcset="">
        </a>
    </div>
</div>
</div>
  

</script>
</body>

</html>