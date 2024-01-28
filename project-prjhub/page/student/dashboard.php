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
    <link rel="stylesheet" href="../../style/dashboard/dashboard.css">
   
    
    <title>dashboard</title>
</head>

<body >
  <div class="nav">
      <div class="logo-img">
          <img src="../../asset/image/navLogo.png" alt="nav-logo">
      </div>
      <div class="logo-text">
           Project Hub
      </div>
      <div class="notf-icon-cont">

      </div>
      <div class="user-icon-cont"></div>
  </div>

  <?php
    $slQry1 = "SELECT * FROM student Where Guide_Id=0 and U_Id = '$user_id'";
    $slresult1 = mysqli_query($conn,$slQry1) or die(mysqli_error($slresult1));
    if(mysqli_num_rows($slresult1)>0){
         $slQry2 = "SELECT * FROM guide WHERE No_of_Students < 4";
         $slresult2 = mysqli_query($conn, $slQry2)or die(mysqli_error($slresult2));

         // Check if the query was successful
         if ($slresult2) {
             // Check if there are guides found
             if (mysqli_num_rows($slresult2) > 0) {
                 // Output the guide's names
                 while ($row = mysqli_fetch_assoc($slresult2)) {
                
                     echo'<div class="g-card">';
                       echo'<div class="g-card-inner">';
                          echo'<div class="g-card-left">';
                              echo '<img src="../../asset/image/' . $row['pfp'] . '">';
                          echo'</div>';
                          echo '<div class="g-card-right">';
                              echo $row['G_Name'] . "<br>";
                              echo'<button id="'.$row['Guide_Id'].'">select</button>';
                          echo'</div>';
                        echo'</div>';
                     echo'</div>';
                 }
            
             } else {
                 echo "No suitable guide found."; // Handle case where no suitable guide is found
             }
         } else {
        // Handle query error
             echo "Error: " . mysqli_error($conn);
         }
    } else {
        echo '<div class="add-prj-cont">';
        echo '<button class="add-btn" onclick="addInputField()"><img src="../../asset/image/plus.png" alt="add Project"></button>';
        echo '<h1>Add Project</h1>';
        echo '</div>';
    }

?>
<div id="inputContainer">
    <label for="prjName">Project Name</label><br>
    <input type="text" name="prjName" id="prjName">
    <button class="submitBtn">Submit</button><button class="cancelBtn">Cancel</button>
</div>
<script src="../../script/student/dashboard/dashboard.js"></script>
   
   <script src="/dependancies/jquery.js"></script>

</body>

</html>