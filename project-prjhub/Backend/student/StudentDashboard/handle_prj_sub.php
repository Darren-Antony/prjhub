<?php
require_once('../../../page/config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $projectName = $_POST['prjName'];
    $selectQry = "SELECT * FROM student WHERE U_Id=$user_id";
    $sresult= mysqli_query($conn,$selectQry);
    $Row = mysqli_fetch_assoc($sresult);
    $guide_Id = $Row['Guide_Id'];
    $Stu_Id = $Row['Dept_No'];
    $projectDescription = $_POST['prj_Desc'];
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s');
    if (!empty($projectName) && !empty($projectDescription)) {
        $ChkForDupliacte = "SELECT * FROM project WHERE Prj_Name='$projectName' or Prj_Desc='$projectDescription' ";
        $result = mysqli_query($conn,$ChkForDupliacte);
        if(mysqli_num_rows($result)>0){
            echo"Prj exist";

        } else {
            $insrtQuery = "INSERT INTO project (Stu_Id,Guide_Id,Prj_Name,Prj_Desc,Prj_Status,Date_of_Submission,Time_of_Submission) VALUES ('$Stu_Id','$guide_Id','$projectName','$projectDescription','Pending-Approval','$currentDate','$currentTime')";

            $result =mysqli_query($conn,$insrtQuery);
            if ($result) {
                echo "Project added successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    
    } else {
        // Handle empty or invalid form data
        echo "Please fill in all fields.";
    }
} else {
    // If the request method is not POST, handle accordingly
    echo "Invalid request method.";
}
?>
