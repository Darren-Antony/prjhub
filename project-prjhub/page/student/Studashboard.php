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
    <title>Student Dashboard</title>
    <script src="../../script/student/dashboard/dashboard.js"></script>
    <script src="../../dependancies/jquery.js"></script>
    <script src="../../script/student/dashboard/ajax/selectingGuideajax.js"></script>
    <script src="../../script/student/dashboard/ajax/submitProjectAjax.js"></script>
    

</head>

<body>
<div class="logo-cont">
        <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>
    
  <?php
     $slQry1 = "SELECT * FROM student WHERE Guide_Id IS NULL AND U_Id = '$user_id'";
     $slresult1 = mysqli_query($conn,$slQry1) or die(mysqli_error($slresult1));
     $sRow = mysqli_fetch_assoc($slresult1);

     $ChkPrjQry = "SELECT * FROM project Where Prj_Status='pending-approval'or Prj_Status='in-progress'";
     $ChkPrjQryRes = mysqli_query($conn,$ChkPrjQry);
     $ssRow = mysqli_fetch_assoc($ChkPrjQryRes);
     if (mysqli_num_rows($slresult1) > 0) {
        $sYear = mysqli_real_escape_string($conn, $sRow['Cur_Year']);
        $sSection = mysqli_real_escape_string($conn, $sRow['Section']);
        $sDegree = mysqli_real_escape_string($conn, $sRow['Degree']);
    
        // Construct the SQL query using prepared statements
        $slQry2 = "SELECT guide.G_Name,guide.Guide_Id
            FROM guide
            LEFT JOIN (
                SELECT Guide_Id, COUNT(*) AS num_students
                FROM student
                WHERE Cur_Year = ? AND Section = ? AND Degree = ?
                GROUP BY Guide_Id
            ) AS student_counts ON guide.Guide_Id = student_counts.Guide_Id
            WHERE (student_counts.num_students < 4 OR student_counts.num_students IS NULL)";
    
        // Prepare the statement
        $stmt = mysqli_prepare($conn, $slQry2);
    
        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "sss", $sYear, $sSection, $sDegree);
    
            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                // Get result
                $slresult2 = mysqli_stmt_get_result($stmt);
    
                // Check if there are guides found
                if (mysqli_num_rows($slresult2) > 0) {
                    // Output the guide's names
                   echo'<h1 class="chs-gud-ttl">Choose Your Guide</h1>';
                    while ($row = mysqli_fetch_assoc($slresult2)) {
                        
                        echo '<div class="g-card">';
                          echo  '<div class="g-card-inner">';
                             echo '<div class="guide-name">'.$row['G_Name'].'</div>' ;
                             echo '<div class="guide-btn">';
                             echo '<button class="blue-btn" id="' . $row['Guide_Id'] . '" onclick="SelectGuide(this.id)">Select</button>';
                             echo '</div>';     
                          echo '</div>';  
                        echo '</div>';  
                    }
                } else {
                    echo "No suitable guides found."; // Handle case where no suitable guide is found
                }
            } else {
                // Handle query execution error
                echo "Error executing query: " . mysqli_error($conn);
            }
    
           
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($conn);
        }
     } else if(mysqli_num_rows($ChkPrjQryRes) > 0){
        $selectQry = "SELECT * FROM student WHERE U_Id='$user_id'";
$sresult = mysqli_query($conn, $selectQry);
$Row = mysqli_fetch_assoc($sresult);
$guide_Id = $Row['Guide_Id'];
$Stu_Id = $Row['Dept_No'];

$Prjstatus1 = "SELECT * FROM project WHERE Stu_Id='$Stu_Id' AND Prj_Status = 'In-Progress'";
$result1 = mysqli_query($conn, $Prjstatus1);

$Prjstatus2 = "SELECT * FROM project WHERE Stu_Id='$Stu_Id' AND Prj_Status = 'pending-approval'";
$result2 = mysqli_query($conn, $Prjstatus2);
echo'<h1 class="heading">Your Projects</h1>';
echo '<div class="main-prj-cont">';

if (mysqli_num_rows($result1) > 0) {
    $PrjPrgsrow = mysqli_fetch_assoc($result1); 
    echo'<div class="inner-prj-cont">';
    echo '<div class="Progress-bar-cont">';
    echo "progress";
    echo "</div>";
    echo '<div class="Project-name-cont">';
    echo $PrjPrgsrow['Prj_Name']; // Assuming 'Prj_title' is the column name
    echo "</div>";
    echo '<div class="view-btn">';
    echo '<button class="blue-btn" onclick="viewPrj(' . $PrjPrgsrow['Prj_Id'] . ')">view</button>';
    echo "</div>";
    echo "</div>";    
} else if (mysqli_num_rows($result2) > 0) {
    $PrjAprrow = mysqli_fetch_assoc($result2); 
    echo '<div class="Progress-bar-cont">';
    echo "Pending Approval";
    echo "</div>";
    echo '<div class="Project-name-cont">';
    echo $PrjAprrow['Prj_Name']; // Assuming 'Prj_title' is the column name
    echo "</div>";
    echo '<div class="view-btn">';
    echo '<button class="cancel-btn>view</button>';
    echo "</div>";
    echo "</div>";
}
echo "</div>";    
echo "</div>"; // Close the main-prj-cont div
 
        }
            
    
    
    else  {
        echo '<div class="form">';
        echo '<form id="projectForm" action="#" method="post">';
        echo '<div class="form-cont">';
        echo '<label for="prjName">Project Name</label><br>';
        echo '<input type="text" name="prjName" id="prjName"><br>';
        
        echo '<label for="prj-desc">Description</label><br>';
        echo '<textarea name="prj_Desc" id="prj-desc" cols="40" rows="10"></textarea><br>';
        
        echo '<button class="blue-btn" onclick="submitProject()">Submit</button>';      
        echo '</div>';
        echo '</form>';
        echo '</div>';
        
   
    }  
?>
 


  


</body>

</html>