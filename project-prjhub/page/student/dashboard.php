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
   
    
    <title>dashboard</title>
</head>

<body >
<div class="logo-cont">
        <img src="../../asset/image/Logo.png" alt="" srcset="">
        <h1>Academic Project Tracker</h1>
    </div>

  <?php
     $slQry1 = "SELECT * FROM student WHERE Guide_Id IS NULL AND U_Id = '$user_id'";
     $slresult1 = mysqli_query($conn,$slQry1) or die(mysqli_error($slresult1));
     $sRow = mysqli_fetch_assoc($slresult1);
     if (mysqli_num_rows($slresult1) > 0) {
        $sYear = mysqli_real_escape_string($conn, $sRow['Cur_Year']);
        $sSection = mysqli_real_escape_string($conn, $sRow['Section']);
        $sDegree = mysqli_real_escape_string($conn, $sRow['Degree']);
    
        // Construct the SQL query using prepared statements
        $slQry2 = "SELECT guide.G_Name
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
                                 echo '<button class="cancel-btn">Cancel</button>
                                       <button class="blue-btn">Select</button>';
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
    } else {
        echo'<button class="blue-btn">Add Project</button>';
    }  
?>
 <div class='form'>
 <form action="#" method="post">
     <div class="form-cont">
         <label for="prjName">Project Name</label><br>
         <input type="text" name="prjName" id="prjName"><br>
     
          <label for="prj-desc">Description</label><br>
          <textarea name="prj_Desc" id="prj-desc" cols="40" rows="10"></textarea><br>
     
         <button class="blue-btn">Submit</button><button class="cancel-btn">Cancel</button>
     </div>
     </form>
 </div>
<script src="../../script/student/dashboard/dashboard.js"></script>
<script src="/dependancies/jquery.js"></script>

</body>

</html>