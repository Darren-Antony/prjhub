<?php
require_once('../config.php');
session_start();
$user_id = $_SESSION['user_id'];
echo $user_id;
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
// Your PHP code goes here

// Check if the student is not assigned a guide
$slQry1 = "SELECT * FROM student WHERE Guide_Id IS NULL AND U_Id = '$user_id'";
$slresult1 = mysqli_query($conn, $slQry1) or die(mysqli_error($conn));

$slQry2 = "SELECT * FROM student WHERE U_Id = $user_id";
$slresult2 = mysqli_query($conn, $slQry2) or die(mysqli_error($conn));

$sRow = mysqli_fetch_assoc($slresult2);
$Stu_Id = $sRow['Dept_No'];

// Check if there are projects pending approval or in progress
$ChkPrjQry = "SELECT * FROM project WHERE (Prj_Status='Pending-Approval' OR Prj_Status='In-Progress') AND Stu_Id='$Stu_Id'";
$ChkPrjQryRes = mysqli_query($conn, $ChkPrjQry) or die(mysqli_error($ChkPrjQryRes));
if (mysqli_num_rows($slresult1) >0) {
    // Display guide selection options
    $sRow = mysqli_fetch_assoc($slresult1);
    $sYear = mysqli_real_escape_string($conn, $sRow['Cur_Year']);
    $sSection = mysqli_real_escape_string($conn, $sRow['Section']);
    $sDegree = mysqli_real_escape_string($conn, $sRow['Degree']);

    $slQry2 = "SELECT guide.G_Name,guide.Guide_Id
        FROM guide
        LEFT JOIN (
            SELECT Guide_Id, COUNT(*) AS num_students
            FROM student
            WHERE Cur_Year = ? AND Section = ? AND Degree = ?
            GROUP BY Guide_Id
        ) AS student_counts ON guide.Guide_Id = student_counts.Guide_Id
        WHERE (student_counts.num_students < 4 OR student_counts.num_students IS NULL)";

    $stmt = mysqli_prepare($conn, $slQry2);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $sYear, $sSection, $sDegree);

        if (mysqli_stmt_execute($stmt)) {
            $slresult2 = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($slresult2) > 0) {
                echo '<h1 class="chs-gud-ttl">Choose Your Guide</h1>';
                while ($row = mysqli_fetch_assoc($slresult2)) {
                    echo '<div class="g-card">';
                    echo '<div class="g-card-inner">';
                    echo '<div class="guide-name">' . $row['G_Name'] . '</div>';
                    echo '<div class="guide-btn">';
                    echo '<button class="blue-btn" id="' . $row['Guide_Id'] . '" onclick="SelectGuide(this.id)">Select</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No suitable guides found.";
            }
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

} elseif (mysqli_num_rows($ChkPrjQryRes)>0) {
    // Display projects for the student
    echo '<h1 class="heading">Your Projects</h1>';
    
    echo '<div class="main-prj-cont">';
    while ($ssRow = mysqli_fetch_assoc($ChkPrjQryRes)) {
        echo '<div class="inner-prj-cont">';
        if ($ssRow['Prj_Status'] === 'in-progress') {
            echo '<div class="Progress-bar-cont">In Progress</div>';
        } elseif ($ssRow['Prj_Status'] === 'pending-approval') {
            echo '<div class="Progress-bar-cont">Pending Approval</div>';
        }
        
        echo '<div class="Project-name-cont">' . $ssRow['Prj_Name'] . '</div>';
        echo '<div class="view-btn">';
        echo '<button class="blue-btn" onclick="viewPrj(' . htmlspecialchars($ssRow['Prj_Id']) . ')">View</button>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';

} else {
    // Display project submission form
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